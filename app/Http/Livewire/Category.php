<?php

namespace App\Http\Livewire;

use Livewire\Component;

class Category extends Component
{
    public function render()
    {
        $data = \App\Models\Category::all();
        return view('categories', ['data' => $data]);
    }
}