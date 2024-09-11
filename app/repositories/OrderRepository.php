<?php

namespace App\repositories;

use App\Models\Item;
use App\Models\Order;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Validator;

class OrderRepository
{
    public function store($request): JsonResponse
    {
        $order = Order::create([
            'user_id' => $request->user()->id,
            'shipping_address' => $request->shipping_address,
            'status' => Order::STATUS_CONFIRMED,
        ]);
        $totalPrice = 0;
        foreach ($request->items as $itemData) {
            $item = Item::find($itemData['item_id']);
            $itemVariant = $item->variants()->where(['item_id' => $item->id, 'color' => $itemData['color'], 'size' => $itemData['size']])->first();
            $itemVariant->update(['quantity' => $itemVariant->quantity - $itemData['quantity']]);
            $itemPrice = $item->price;
            $order->items()->create([
                'item_id' => $itemData['item_id'],
                'quantity' => $itemData['quantity'],
                'color' => $itemData['color'],
                'price' => Item::find($itemData['item_id'])->price,
                'size' => $itemData['size']
            ]);
            $totalPrice = $totalPrice + ($itemPrice * $itemData['quantity']);
        }
        $randomNumber = rand(1000, 9999); // Generate a 4-digit random number
        $generatedOrderId = 'AI' . $randomNumber . $order->id;
        $order->update(['total' => $totalPrice, 'order_id' => $generatedOrderId]);

        return response()->json([
            'message' => 'Order created successfully.',
            'order' => $order->load('items'),
        ], 200);
    }

    public function getUserOrders($request)
    {
        $orders = Order::with(['items', 'items.item'])->withCount('items')  // Eager load item count for each order
        ->where('user_id', $request->user()->id)
            ->get();

        // Modify each order to include item count if needed explicitly
        foreach ($orders as $order) {
            $order->status_name = Order::getStatusName($order->status);
        }

        // Optionally you can format or return additional data
        return $orders;
    }
}