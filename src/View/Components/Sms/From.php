<?php

namespace Seven\Bagisto\View\Components\Sms;

use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class From extends Component
{
    public function __construct(public string $value)
    {
    }

    public function render(): View|Closure|string
    {
        return view('seven::components.sms.from');
    }
}
