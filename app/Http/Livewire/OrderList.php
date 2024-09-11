<?php

namespace App\Http\Livewire;

use App\Models\Order;
use Livewire\Component;

class OrderList extends Component
{
    public function render()
    {
        $data = Order::all();
        return view('orders', ['data' => $data]);
    }
}