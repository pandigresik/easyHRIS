<?php

namespace App\View\Components;

use Illuminate\View\Component;

class Tabs extends Component
{
    public $data;

    /**
     * Create a new component instance.
     *
     * @param mixed $data
     */
    public function __construct($data)
    {
        $this->data = $data;
    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return \Closure|\Illuminate\Contracts\View\View|string
     */
    public function render()
    {
        return view('components.tabs', ['data' => $this->data]);
    }
}
