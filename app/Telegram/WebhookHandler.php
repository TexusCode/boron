<?php

namespace App\Telegram;

use App\Http\Controllers\SmsController;
use App\Models\ChatStatus;
use App\Models\Deliver;
use App\Models\Order;
use App\Models\OtherPhoto;
use App\Models\Product;
use DefStudio\Telegraph\Enums\ChatActions;
use DefStudio\Telegraph\Keyboard\Button;
use DefStudio\Telegraph\Keyboard\Keyboard;
use DefStudio\Telegraph\Keyboard\ReplyButton;
use DefStudio\Telegraph\Keyboard\ReplyKeyboard;
use Illuminate\Support\Stringable;
use Illuminate\Notifications\Action;
use DefStudio\Telegraph\Models\TelegraphChat;
use DefStudio\Telegraph\Telegraph;
use GuzzleHttp\Client;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Storage;

class WebhookHandler extends \DefStudio\Telegraph\Handlers\WebhookHandler
{
    public function start(): void
    {
        // $this->chat->photo('https://i.postimg.cc/wjJ9Vwmv/i-E-HFN-NHFYCGJHN-copy.jpg')
        //     ->send();
        $this->chat->message("Здравствуйте! 📲 Отправьте код товара, и я вышлю вам изображение товара и ссылку на него!")->send();
    }
    public function deliver(): void
    {
        // Fetch the chat status based on the chat ID
        $chatId = $this->message->from()->id(); // Get the user's ID
        $chat_status = ChatStatus::where('chat_id', $chatId)->first();

        if ($chat_status) {
            // Update the existing chat status
            $chat_status->status = 'phone';
            $chat_status->save();
        } else {
            $chat_status = new ChatStatus();
            $chat_status->chat_id = $chatId; // Use the user ID directly
            $chat_status->status = 'phone';
            $chat_status->phone = 'default';
            $chat_status->save();
        }

        $this->chat->message("Здравствуйте! 📲 Отправьте свой номер телефона для подтверждения!")->send();
    }

    public function handleChatMessage(Stringable $text): void
    {
        $chatId = $this->message->from()->id(); // Get the user's ID
        $chat_status = ChatStatus::where('chat_id', $chatId)->first();
        if ($chat_status->status === 'phone') {
            // Check if the user is a deliverer and if the phone number is valid
            $text = $this->message->text(); // Get the user's input for the phone number
            $deliver = Deliver::where('phone', $text)->first();

            if ($deliver) {
                // Generate and send confirmation code
                $code = sprintf('%04d', rand(0, 9999));
                $chat_status->phone = $text; // Store the phone number
                $chat_status->code = $code; // Store the generated code
                $chat_status->status = 'code'; // Update status to 'code'
                $chat_status->save();

                // Send SMS with the confirmation code
                $smsController = new SmsController();
                $message = "Код подтверждения для телеграм бот: $code";
                $smsController->sendSms($text, $message); // Send SMS

                // Notify user to enter the code
                $this->chat->message("Я отправил код подтверждения на номер $text; Введите его здесь!")->send();
            } else {
                // User not found or invalid phone number
                $this->chat->message("Вы не являетесь доставщиком или номер телефона написан неправильно")->send();
            }
        } elseif ($chat_status->status === 'code') {
            // Verify the entered confirmation code
            $cod = $chat_status->code;
            $text = $this->message->text(); // Get the user's input

            if ($cod === $text) {
                // Code is correct, update status to 'active'
                $chat_status->status = 'active';
                $chat_status->save();
                $this->chat->message("Вы успешно вошли в систему! Когда админ выбирает вас в заказы, вам придут уведомления")->send();
            } else {
                // Code is incorrect
                $this->chat->message("Код неверный, попробуйте еще раз.")->send();
            }
        } elseif ($text == 'moysklad') {
            $this->chat->message("moysklad")->send();
            sleep(120);

        }elseif ($text) {
            $product = Product::where('code', $text)->first();

            if ($product) {
                $description =  $product->description ?? 'Нет описание';
                $this->chat->photo("https://boron.tj/storage/app/public/$product->miniature")->send();
                $otherphotos = OtherPhoto::where('product_id', $product->id);
                if ($otherphotos) {
                    foreach ($otherphotos as $photo) {
                        $this->chat->photo("https://boron.tj/storage/app/public/$photo->photo")->send();
                    }
                }
                $this->chat->message("Названия товара: $product->name.\nОписание товара: $description \nЦена товара: $product->price c.")->send();
                $this->chat->message("https://boron.tj/details/$product->id")->send();
            } else {
                $this->chat->message("Товар не найден!")->send();
            }
        }
    }


    public function sendmess($order, $chat)
    {
        $chatid = ChatStatus::find($chat);
        $user = TelegraphChat::where('chat_id', $chatid->chat_id)->first();
        $id = $user->id;
        $chat = TelegraphChat::find($id);
        $order = Order::find($order);
        $user_phone = $order->user->phone;
        $chat->message("Номер заказ №$order->id\nТелефон клиент: $user_phone\nГород: $order->city\nАдрес клиент: $order->location\nСпособ оплата: $order->payment\nСумма к коплате: $order->total c\n")->send();
        foreach ($order->suborders as $suborder) {
            if ($suborder->status == 'Подтверждено') {
                $product = $suborder->product;
                $seller = $product->seller->store_name;
                $chat->message("Код товара: ($product->code) введите код товара ниже я отправляю данные товара!")->send();
                $chat->message("Магазин: $seller")->send();
                $chat->photo("https://boron.tj/storage/app/public/$product->miniature")->send();
            }
        }
    }
}
