<?php

namespace App\Http\Livewire;

use App\Models\Category;
use Illuminate\View\View;
use Livewire\Component;


class CategoryComponent extends Component
{
    public $topCategories;

    public function mount(){
        $this->topCategories =  Category::whereCategoryType('auction')->where('parent_id', null)->orderBy('category_name', 'asc')->get();
    }
    public function updateTopCategories($value){

        $this->topCategories = Category::whereCategoryType('auction')->where('parent_id', $value)->orderBy('category_name', 'asc')->get();
    }

    public function render(): View
    {
        return view('livewire.category-component')->with('topCategories', $this->topCategories);
    }
}
