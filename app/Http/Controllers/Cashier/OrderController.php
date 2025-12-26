<?php

namespace App\Http\Controllers\Cashier;
use App\Http\Controllers\SmsController;
use App\Models\Order;
use App\Models\Product;
use App\Models\SmsTemplate;
use App\Models\SubOrder;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\URL;
use Illuminate\Support\Str;

class OrderController extends CashierBaseController
{
    public function index()
    {
        $orders = Order::with('user')
            ->where('cashier_id', Auth::id())
            ->orderByDesc('created_at')
            ->paginate(20);

        return view('cashier.pages.orders.index', array_merge(compact('orders'), $this->viewOptions()));
    }

    public function create()
    {
        $products = Product::orderBy('name')->get();
        $couriers = User::whereIn('role', ['deliver', 'courier'])->orderBy('name')->get();

        return view('cashier.pages.orders.create', array_merge(compact('products', 'couriers'), $this->viewOptions()));
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'customer_name' => ['required', 'string', 'max:255'],
            'customer_phone' => ['required', 'string', 'max:32'],
            'payment' => ['nullable', 'string', 'max:255'],
            'delivery_type' => ['nullable', 'string', 'max:255'],
            'city' => ['nullable', 'string', 'max:255'],
            'location' => ['nullable', 'string', 'max:255'],
            'note' => ['nullable', 'string', 'max:1000'],
            'product_id' => ['nullable', 'array'],
            'product_id.*' => ['required', 'integer', 'exists:products,id'],
            'quantity' => ['nullable', 'array'],
            'quantity.*' => ['required', 'integer', 'min:1'],
            'subtotal' => ['nullable', 'numeric', 'min:0'],
            'discount' => ['nullable', 'numeric', 'min:0'],
            'total' => ['nullable', 'numeric', 'min:0'],
            'courier_id' => ['nullable', 'integer', 'exists:users,id'],
        ]);

        $user = User::firstOrNew(['phone' => $data['customer_phone']]);
        if (!$user->exists) {
            $user->role = 'customer';
        }
        $user->name = $data['customer_name'];
        $user->save();

        $subtotal = 0;
        $suborders = [];
        if (!empty($data['product_id'])) {
            foreach ($data['product_id'] as $index => $productId) {
                $quantity = $data['quantity'][$index] ?? 1;
                $product = Product::find($productId);
                if (!$product) {
                    continue;
                }
                $price = $product->display_price;
                $subtotal += $price * $quantity;

                $suborders[] = [
                    'product_id' => $product->id,
                    'count' => $quantity,
                    'price' => $price,
                    'discount' => 0,
                    'seller_id' => $product->seller_id,
                    'status' => 'Ожидание',
                ];
            }
        }

        $subtotal = $data['subtotal'] ?? $subtotal;
        $discount = $data['discount'] ?? 0;
        $total = $data['total'] ?? max(0, $subtotal - $discount);

        $order = Order::create([
            'no' => 'CSH-' . now()->format('Ymd') . '-' . str_pad((string) random_int(1, 99999), 5, '0', STR_PAD_LEFT),
            'user_id' => $user->id,
            'cashier_id' => Auth::id(),
            'subtotal' => $subtotal,
            'delivery_price' => 0,
            'tax' => 0,
            'discount' => $discount,
            'total' => $total,
            'city' => $data['city'] ?? null,
            'location' => $data['location'] ?? null,
            'payment' => $data['payment'] ?? 'Наличные',
            'delivery_type' => $data['delivery_type'] ?? 'Самовывоз',
            'note' => $data['note'] ?? null,
            'status' => 'Ожидание',
            'deliver_boy_id' => $data['courier_id'] ?? null,
        ]);

        foreach ($suborders as $suborder) {
            $suborder['order_id'] = $order->id;
            SubOrder::create($suborder);
        }

        if (!empty($data['courier_id'])) {
            $courier = User::whereIn('role', ['deliver', 'courier'])->find($data['courier_id']);
            if ($courier && $courier->phone) {
                $sms = new SmsController();
                $sms->sendSms($courier->phone, $this->buildCourierMessage($order));
            }
        }

        return redirect()->route($this->routePrefix() . 'orders.show', $order)->with('success', 'Заказ создан.');
    }

    public function show(Order $order)
    {
        $order->load(['user', 'suborders.product']);
        $templates = SmsTemplate::orderBy('title')->get();

        return view('cashier.pages.orders.show', array_merge(compact('order', 'templates'), $this->viewOptions()));
    }

    public function updateStatus(Request $request, Order $order)
    {
        $data = $request->validate([
            'status' => ['required', 'string', 'max:255'],
        ]);

        $previousStatus = $order->status;
        $order->status = $data['status'];
        $order->save();

        if ($previousStatus !== 'Доставлен' && $order->status === 'Доставлен') {
            $phone = $order->user->phone ?? null;
            if ($phone) {
                $sms = new SmsController();
                $sms->sendSms($phone, $this->buildDeliveredMessage($order));
            }
        }

        return back()->with('success', 'Статус заказа обновлен.');
    }

    public function sendSms(Request $request, Order $order)
    {
        $data = $request->validate([
            'template_id' => ['required', 'integer', 'exists:sms_templates,id'],
        ]);

        $template = SmsTemplate::findOrFail($data['template_id']);
        $message = $this->hydrateTemplate($template->body, $order);

        $phone = $order->user->phone ?? null;
        if ($phone) {
            $sms = new SmsController();
            $sms->sendSms($phone, $message);
        }

        return back()->with('success', 'SMS отправлено.');
    }

    private function hydrateTemplate(string $body, Order $order): string
    {
        $replacements = [
            '{order_id}' => (string) $order->id,
            '{client_name}' => $order->user->name ?? 'Клиент',
            '{total}' => number_format($order->total ?? 0, 2, '.', ' '),
            '{status}' => $order->status ?? '—',
        ];

        return str_replace(array_keys($replacements), array_values($replacements), $body);
    }

    private function buildCourierMessage(Order $order): string
    {
        $lines = [
            "Новый заказ #{$order->id}",
            "Клиент: " . ($order->user->name ?? '—'),
            "Телефон: +992 " . ($order->user->phone ?? '—'),
            "Адрес: " . trim(($order->city ?? '') . ' ' . ($order->location ?? '')),
            "Оплата: " . ($order->payment ?? '—'),
            "Сумма: " . number_format($order->total ?? 0, 2, '.', ' ') . ' c',
        ];

        return implode(PHP_EOL, $lines);
    }

    private function buildClientMessage(Order $order): string
    {
        return "Ваш заказ №{$order->id} создан. Сумма: " . number_format($order->total ?? 0, 2, '.', ' ') . " c.";
    }

    private function buildDeliveredMessage(Order $order): string
    {
        if (!$order->review_token) {
            $order->review_token = Str::random(40);
            $order->save();
        }

        $link = URL::temporarySignedRoute(
            'order-review.show',
            now()->addDays(7),
            ['token' => $order->review_token]
        );

        return "Ваш заказ №{$order->id} успешно доставлен. Оставьте отзыв: {$link}";
    }
}
