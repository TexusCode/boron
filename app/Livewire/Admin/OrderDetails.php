<?php

namespace App\Livewire\Admin;

use App\Http\Controllers\SmsController;
use App\Models\Order;
use App\Models\SubOrder;
use App\Models\User;
use Livewire\Component;
use Illuminate\Support\Facades\URL;
use Illuminate\Support\Str;

class OrderDetails extends Component
{
    public $order;
    public $couriers;
    public $deliver;
    public $status;

    public function mount($order)
    {
        $this->order = Order::find($order);
        $this->couriers = User::whereIn('role', ['deliver', 'courier'])->get();
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
        } elseif ($order->status == 'Передан курьеру') {
            $message = "Заказ №$order->id передан курьеру.";
        } elseif ($order->status == 'Отправлен') {
            $message = "Заказ №$order->id был отправлен. Пожалуйста, оставайтесь на связи для получения.";
        } elseif ($order->status == 'Доставлен') {
            if (!$order->review_token) {
                $order->review_token = Str::random(40);
                $order->save();
            }
            $link = URL::temporarySignedRoute(
                'order-review.show',
                now()->addDays(7),
                ['token' => $order->review_token]
            );
            $message = "Заказ №$order->id был успешно доставлен. Оставьте отзыв: $link";
        } elseif ($order->status == 'Отменено') {
            $message = "Заказ №$order->id был отменен. Если у вас есть вопросы, пожалуйста, свяжитесь с нашей службой поддержки.";
        } else {
            $message = "Статус заказа №$order->id неизвестен. Пожалуйста, проверьте информацию.";
        }

        $smsController = new SmsController();
        $smsResponse = $smsController->sendSms($phone, $message);
    }
    public function updatedDeliver()
    {
        $order = $this->order;
        $order->deliver_boy_id = $this->deliver;
        $order->save();

        $courier = User::whereIn('role', ['deliver', 'courier'])->find($this->deliver);
        if (!$courier || !$courier->phone) {
            return;
        }

        $message = "Новый заказ #{$order->id}\n"
            . "Клиент: " . ($order->user->name ?? '—') . "\n"
            . "Телефон: +992 " . ($order->user->phone ?? '—') . "\n"
            . "Адрес: " . trim(($order->city ?? '') . ' ' . ($order->location ?? '')) . "\n"
            . "Оплата: " . ($order->payment ?? '—') . "\n"
            . "Сумма: " . number_format($order->total ?? 0, 2, '.', ' ') . " c";
        $smsController = new SmsController();
        $smsController->sendSms($courier->phone, $message);

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
