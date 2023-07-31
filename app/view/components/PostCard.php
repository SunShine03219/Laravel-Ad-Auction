<?php

namespace App\View\Components;
use Illuminate\View\Component;

class PostCard extends Component
{
    public $ad;

    public function __construct($ad)
    {
        $this->ad = $ad;
    }
    public function render()
    {
        return view('components.postcard');
    }
}
