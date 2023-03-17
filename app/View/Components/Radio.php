<?php

namespace App\View\Components;

use Illuminate\View\Component;

class Radio extends Component
{
    public $id;
    public $value;
    public $input;
    public $disabled;

    /**
     * Create a new component instance.
     *
     * @return void
     */
    public function __construct($id, $value, $input=null, $disabled=false)
    {
        $this->id = $id;
        $this->value = $value;
        $this->input = $input;
        $this->disabled = $disabled;
    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\Contracts\View\View|\Closure|string
     */
    public function render()
    {
        return view('components.radio');
    }
}
