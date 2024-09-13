<?php

namespace App\Http\Controllers;

use App\Http\Requests\CheckProducerCodeRequest;
use App\Http\Requests\CreateItemRequest;
use App\Http\Requests\DeleteItemRequest;
use App\Http\Requests\ExistingProducerCodeRequest;
use App\Http\Requests\PlaceOrderRequest;
use App\Http\Requests\UpdateItemRequest;
use App\Mail\OrderPlaced;
use App\Models\Category;
use App\Models\Item;
use App\Models\Order;
use App\Models\User;
use App\repositories\ItemRepository;
use App\repositories\OrderRepository;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;
use Yajra\DataTables\DataTables;

class ItemsController extends Controller
{
    protected $item;

    public function __construct(ItemRepository $item)
    {
        $this->item = $item;
    }

    public function itemTableData($type): JsonResponse
    {
        $itemList = Item::where('type', $type)->with(['category', 'variants'])->get();
        return DataTables::of($itemList)
                ->addColumn('imageData', function ($item) {
                    return '<div><img src="'.$item->image.'"></div>';
                })
                ->addColumn('action', function ($item) {
                    return $this->tableActions();
                })
                ->rawColumns(['action', 'imageData'])
                ->make(true);
    }

    public function tableActions(): string
    {
        $delete = '<a class="col mb-2 btn btn-neutral-shadow table-action-delete text-primary border-r25" type="button"><span class="btn-inner--icon"><i class="fas fa-trash"></i></span> <span class="btn-inner--text d-none d-sm-inline"></span></a>';
        $edit = '<a class="col mb-2 btn btn-neutral-shadow table-action-edit text-primary border-r25" type="button"><span class="btn-inner--icon"><i class="fas fa-edit"></i></span> <span class="btn-inner--text d-none d-sm-inline"></span></a>';
        return  '<div class="btn-group-sm row justify-content-lg-center mx-0" role="group">'.$edit . $delete . '</div>';
    }

    public function create(CreateItemRequest $request)
    {
        if(Auth::user() && Auth::user()->hasRole(['admin'])){
            return $this->item->create($request);
        }
        return User::abort(403);
    }

    public function update(UpdateItemRequest $request)
    {
        if(Auth::user() && Auth::user()->hasRole(['admin'])){
            return $this->item->update($request);
        }
        return User::abort(403);
    }

    public function delete(DeleteItemRequest $request)
    {
        if(Auth::user() && Auth::user()->hasRole(['admin'])){
           return $this->item->delete($request);
        }
        return User::abort(403);
    }

    public static function getAllItems(): Collection
    {
        return Item::with(['category', 'variants'])->get();
    }

    public function getPredictions()
    {
        return $this->item->getPredictions();
    }
}
