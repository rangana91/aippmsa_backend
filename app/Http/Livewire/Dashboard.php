<?php

namespace App\Http\Livewire;

use App\Models\Item;
use App\Models\Order;
use App\Models\User;
use Livewire\Component;

class Dashboard extends Component
{
    public function render()
    {
        $items = Item::all()->count();
        $orders = Order::all()->count();
        $customers = User::whereHas('roles', function($query) {
            $query->where('name', 'customer');
        })->count();
        return view('dashboard', ['items'=> $items, 'orders' => $orders, 'customers' => $customers]);
    }
}
