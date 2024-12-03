<?php

namespace App\View\Components;

use Illuminate\View\Component;

class FilterModal extends Component
{
    public $title;
    public $fields;

    public function __construct($title, $fields = [])
    {
        $this->title = $title;
        $this->fields = $fields;
    }

    public function render()
    {
        return view('components.filter-modal');
    }
}
