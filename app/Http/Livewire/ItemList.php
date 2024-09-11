<?php

namespace App\Http\Livewire;

use App\Http\Controllers\ItemsController;
use App\Models\Item;
use App\repositories\ItemRepository;
use Livewire\Component;

class ItemList extends Component
{
    public $itemType = '';

    public function mount($item) {
        $this->itemType = $item;
    }

    public function render()
    {
        $itemList = (new ItemRepository())->getItemsByType($this->itemType);
        $categories = \App\Models\Category::all();
        return view('item-list',[
            'itemList' => $itemList,
            'itemType' => $this->itemType,
            'categories' => $categories
        ]);
    }
}