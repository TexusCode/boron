<?php

namespace App\Livewire\Seller;

use App\Models\SubOrder;
use Livewire\Component;

class OrderConfirm extends Component
{
    public $id;
    public $suborder;
    public function mount($id)
    {
        $this->suborder = SubOrder::find($id);
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
        return redirect()->route('orders-seller');
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

        // Redirect to orders-seller route
        return redirect()->route('orders-seller')->with('success', 'SubOrder successfully canceled');
    }

    public function render()
    {
        return view('livewire.seller.order-confirm');
    }
}
