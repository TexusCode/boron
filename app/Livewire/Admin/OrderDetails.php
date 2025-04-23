<?php

namespace App\Livewire\Admin;

use App\Http\Controllers\SmsController;
use App\Models\ChatStatus;
use App\Models\Deliver;
use App\Models\Order;
use App\Models\SubOrder;
use App\Telegram\WebhookHandler;
use Livewire\Component;

class OrderDetails extends Component
{
    public $order;
    public $delivers;
    public $deliver;
    public $status;

    public function mount($order)
    {
        $this->order = Order::find($order);
        $this->delivers = Deliver::all();
        $this->status = $this->order->status;
        $this->deliver = $this->order->deliver_boy_id;
    }

    public function updatedStatus()
    {
        $order = $this->order;
        $order->status = $this->status;
        $order->save();

        $phone = $order->user->phone;
        if ($order->status == 'Подтверждено') {
            $message = "Заказ №$order->id был подтвержден продавцом. Спасибо за ваш выбор!";
        } elseif ($order->status == 'Отправлен') {
            $message = "Заказ №$order->id был отправлен. Пожалуйста, оставайтесь на связи для получения.";
        } elseif ($order->status == 'Доставлен') {
            $message = "Заказ №$order->id был успешно доставлен. Мы надеемся, что вы довольны покупкой!";
        } elseif ($order->status == 'Отменен') {
            $message = "Заказ №$order->id был отменен. Если у вас есть вопросы, пожалуйста, свяжитесь с нашей службой поддержки.";
        } else {
            $message = "Статус заказа №$order->id неизвестен. Пожалуйста, проверьте информацию.";
        }

        $smsController = new SmsController();
        $smsResponse = $smsController->sendSms($phone, $message);
    }
    public function updatedDeliver()
    {
        // dd($this->deliver);
        $order = $this->order;
        $order->deliver_boy_id = $this->deliver;
        $order->save();

        $phone = $order->deliver->phone;
        $message = "У вас новый заказ на доставку! Номер заказ $order->id";
        $smsController = new SmsController();
        $smsResponse = $smsController->sendSms($phone, $message);

        $telegram = new WebhookHandler();
        $chat = ChatStatus::where('phone', $phone)->first();
        $chatbot = $telegram->sendmess($order->id, $chat->id);
    }
    public function confirm($id)
    {
        $suborder = SubOrder::find($id);
        $suborder->status = 'Подтверждено';
        $suborder->save();
        $this->dispatch(
            'alert',
            type: 'success',
            title: 'Заказ успешно подтверждено',
            position: 'top',
        );
        return redirect()->back();
    }
    public function cancel($id)
    {
        $suborder = SubOrder::find($id);

        if (!$suborder) {
            return redirect()->route('orders-seller')->with('error', 'SubOrder not found');
        }

        // Update the status of the suborder
        $suborder->status = 'Отменено';
        $suborder->save();

        $order = $suborder->order;

        if (!$order) {
            return redirect()->route('orders-seller')->with('error', 'Order not found');
        }

        // Calculate the price adjustment
        $price = ($suborder->price * $suborder->count) - $suborder->discount;

        // Adjust the order's totals
        $order->subtotal -= $price;
        $order->total -= $price;
        $order->discount -= $suborder->discount;
        $order->save();

        // Dispatch success message
        $this->dispatch('alert', [
            'type' => 'success',
            'title' => 'Заказ успешно отменено',
            'position' => 'top',
        ]);
        return redirect()->back();

    }
    public function render()
    {
        return view('livewire.admin.order-details');
    }
}
