<?php

namespace App\repositories;

use App\Models\Item;
use App\Models\ItemVariant;
use App\Models\User;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;
use Yajra\DataTables\DataTables;

class ItemRepository
{


    public function getItemsByType($type): JsonResponse
    {
        $itemList = null;
        switch ($type){
            case 'shirt':
                $itemList = Item::where('type', 'shirt')->with('category')->get();
                break;
            case 't-shirt':
                $itemList = Item::where('type', 't-shirt')->get();
                break;
            case 'handbag':
                $itemList = Item::where('type', 'handbag')->get();
                break;
            case 'short':
                $itemList = Item::where('type', 'short')->get();
                break;
            case 'blouse':
                $itemList = Item::where('type', 'blouse')->get();
                break;
            case 'skirt':
                $itemList = Item::where('type', 'skirt')->get();
                break;
            case 'sunglasses':
                $itemList = Item::where('type', 'sunglasses')->get();
                break;
            case 'shoes':
                $itemList = Item::where('type', 'shoes')->get();
                break;
            case 'sandals':
                $itemList = Item::where('type', 'sandals')->get();
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

    public function getPredictions()
    {
        $url = env('AI_MODEL_URL');

        $data = [
            'age' => User::calculateAge(Auth::user()->date_of_birth),
            'gender' => Auth::user()->gender,
            'password' => 'secret',
        ];

        $response = Http::post($url, $data);

        if ($response->successful()) {
            return Item::with(['category', 'variants'])->whereIn('type',$response['top_5_items'])
                ->get();
        } else {
            return response()->json([
                'error' => 'Request failed',
                'status_code' => $response->status(),
            ], $response->status());
        }
    }
}