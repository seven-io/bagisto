<?php

namespace Seven\Bagisto\View\Components;

use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;
use Webkul\Customer\Repositories\CustomerGroupRepository;

class CustomerGroups extends Component
{
    public function __construct(protected readonly CustomerGroupRepository $customerGroupRepository)
    {
    }

    public function render(): View|Closure|string
    {
        $customerGroups = $this->customerGroupRepository->findWhere([['code', '<>', 'guest']]);
        return view('seven::components.customer-groups', compact('customerGroups'));
    }
}
