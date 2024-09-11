<?php

namespace App\repositories;

use App\Models\Item;
use App\Models\ItemVariant;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Auth;
use Yajra\DataTables\DataTables;

class ItemRepository
{


    public function getItemsByType($type): JsonResponse
    {
        $itemList = null;
        switch ($type){
            case 'vinyl':
                $itemList = Item::where('type', 'vinyl')->with('category')->get();
                break;
            case 'cd':
                $itemList = Item::where('type', 'cd')->get();
                break;
            case 'antique':
                $itemList = Item::where('type', 'antique')->get();
                break;
            case 'stamps':
                $itemList = Item::where('type', 'stamps')->get();
                break;
            case 'paintings':
                $itemList = Item::where('type', 'paintings')->get();
                break;
            case 'photos':
                $itemList = Item::where('type', 'photos')->get();
                break;
            case 'books':
                $itemList = Item::where('type', 'books')->get();
                break;
            case 'coins':
                $itemList = Item::where('type', 'coins')->get();
                break;
            default:
                $itemList = Item::all();
                break;
        }
        return DataTables::of($itemList)->make(true);
    }

    public function create($request): JsonResponse
    {
        // Add the main item
        $request->merge(['user_id' => Auth::user()->id]);

        if ($request->imageFile) {
            $image = $request->file('imageFile');
            $imageName = time() . '.' . $image->getClientOriginalExtension();
            $image->storeAs('images', $imageName, 'public');
            $imageUrl = asset('storage/images/' . $imageName);
            $request->merge(['image' => $imageUrl]);
        }

        // Create the item
        $item = Item::create($request->all());

        // Create item variants (multiple sizes and colors)
        foreach ($request->size as $index => $size) {
            ItemVariant::create([
                'item_id' => $item->id,
                'size' => $size,
                'color' => $request->color[$index],
                'quantity' => $request->quantity[$index]
            ]);
        }

        return response()->json('Item successfully added.');
    }

    public function update($request)
    {
        // Find the item by ID
        $item = Item::find($request->id);

        // Merge user_id into the request
        $request->merge(['user_id' => Auth::user()->id]);

        // Handle the image upload if a new image is provided
        if ($request->hasFile('imageFile')) {
            $image = $request->file('imageFile');
            $imageName = time() . '.' . $image->getClientOriginalExtension();
            $image->storeAs('images', $imageName, 'public');
            $imageUrl = asset('storage/images/' . $imageName);
            $request->merge(['image' => $imageUrl]);
        }

        // Update the item details except 'id'
        $item->update($request->except('id'));

        // Handle item variants (size, color, quantity)
        if ($request->has('variants')) {
            // Delete old variants
            ItemVariant::where('item_id', $item->id)->delete();

            // Insert new variants
            foreach ($request->variants as $variant) {
                ItemVariant::create([
                    'item_id' => $item->id,
                    'size' => $variant['size'],
                    'color' => $variant['color'],
                    'quantity' => $variant['quantity'],
                ]);
            }
        }

        return response()->json('Item successfully updated.');
    }


    public function delete($request): JsonResponse
    {
        try {
            $item = Item::find($request->item_id);
            $item->delete();
            return response()->json('Item successfully deleted.');
        } catch (\Exception $exception) {
            return response()->json($exception->getMessage(), 400);
        }
    }
}