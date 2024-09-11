<?php

namespace App\Http\Controllers;

use App\Http\Requests\OrderCreateRequest;
use App\Models\Item;
use App\Models\Order;
use App\Models\User;
use App\repositories\OrderRepository;
use Carbon\Carbon;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Validator;
use Yajra\DataTables\DataTables;

class OrderController extends Controller
{
    protected $order;

    public function __construct(OrderRepository $order)
    {
        $this->order = $order;
    }
    public function store(OrderCreateRequest $request): JsonResponse
    {
        if (Auth::user()->hasRole('customer')){
            return $this->order->store($request);
        }
        return User::abort(403);
    }

    public function getUserOrders(Request $request)
    {
        if (Auth::user()->hasRole('customer')){
            return $this->order->getUserOrders($request);
        }
        return User::abort(403);
    }

    public function orderTableData(): JsonResponse
    {
        $orderList = Order::get();
        return DataTables::of($orderList)
            ->addColumn('customer_name', function ($order) {
                return $order->user->first_name.' '.$order->user->last_name;
            })
            ->addColumn('item', function ($order) {
                return $order->item->name;
            })
            ->addColumn('created_at', function ($order) {
                return Carbon::parse($order->created_at)->format('d-m-Y H:i');
            })
            ->make(true);
    }
}
