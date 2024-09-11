<?php

namespace App\Http\Controllers;

use App\Http\Requests\CategoryCreateRequest;
use App\Http\Requests\CategoryDeleteRequest;
use App\Http\Requests\CategoryUpdateRequest;
use App\Http\Requests\DeleteItemRequest;
use App\Http\Requests\UpdateItemRequest;
use App\Models\Category;
use App\Models\Item;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Yajra\DataTables\DataTables;

class CategoryController extends BaseController
{
    public function create(CategoryCreateRequest $request)
    {
        if(Auth::user() && Auth::user()->hasRole(['admin'])){
            $request->merge(['user_id' => Auth::user()->id]);
            $response = Category::create($request->all());
            return response()->json('Category successfully created');
        }
        abort(403);
    }

    public function update(CategoryUpdateRequest $request)
    {
        if(Auth::user() && Auth::user()->hasRole(['admin'])){
            try {
                $item = Category::find($request->id);
                $request->merge(['user_id' => Auth::user()->id]);
                $item->update($request->except('id'));
                return response()->json('Category successfully updated.');
            } catch (\Exception $e) {
                Log::error($e);
                return response()->json('Category update failed.', 400);
            }

        }
        abort(403);
    }

    public function delete(CategoryDeleteRequest $request)
    {
        if(Auth::user() && Auth::user()->hasRole(['admin'])){
            try {
                $item = Category::find($request->cat_id);
                $item->delete();
                return response()->json('Category successfully deleted.');
            } catch (\Exception $e) {
                Log::error($e);
                return response()->json('Something went wrong.', 400);
            }
        }
        abort(403);
    }

    public function categoryTableData(): JsonResponse
    {
        $itemList = Category::get();
        return DataTables::of($itemList)
            ->addColumn('action', function ($order) {
                return $this->tableActions();
            })
            ->rawColumns(['action'])
            ->make(true);
    }

    public function tableActions(): string
    {
        $delete = '<a class="col mb-2 btn btn-neutral-shadow table-action-delete text-primary border-r25" type="button"><span class="btn-inner--icon"><i class="fas fa-trash"></i></span> <span class="btn-inner--text d-none d-sm-inline"></span></a>';
        $edit = '<a class="col mb-2 btn btn-neutral-shadow table-action-edit text-primary border-r25" type="button"><span class="btn-inner--icon"><i class="fas fa-edit"></i></span> <span class="btn-inner--text d-none d-sm-inline"></span></a>';
        return  '<div class="btn-group-sm row justify-content-lg-center mx-0" role="group">'.$edit . $delete . '</div>';
    }
}
