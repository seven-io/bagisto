<?php

namespace Seven\Bagisto\Http\Controllers;

use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Support\Collection;
use Illuminate\View\View;
use Seven\Bagisto\Services\Configuration;
use Seven\Bagisto\Services\Seven;
use Webkul\Customer\Models\Customer;
use Webkul\Customer\Repositories\CustomerGroupRepository;
use Webkul\Customer\Repositories\CustomerRepository;

class BulkController extends Controller {
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;

    public function __construct(
        protected Seven $seven,
        protected CustomerGroupRepository $customerGroupRepository,
        protected CustomerRepository $customerRepository,
        protected Configuration $configuration
    ) {}

    /**
     * @return Customer[]
     */
    protected function getCustomers(Request $request): array {
        $customerGroupId = $request->post('customerGroupId');

        /** @var Collection $collection */
        $where = [];
        if ($customerGroupId) $where['customer_group_id'] = (int)$customerGroupId;
        $collection = $this->customerRepository->findWhere($where);
        return $collection->all();
    }

    public function index(): View {
        $customerGroups = $this->customerGroupRepository->findWhere([['code', '<>', 'guest']]);
        $from = $this->configuration->getSmsFrom();
        return view('seven::bulk.index', compact('customerGroups', 'from'));
    }

    public function sms(): RedirectResponse {
        $request = request();

        if ($request->method() === 'POST') {
            $request->validate([
                'from'  => [
                    //'regex:/^([+]?[0-9]{1,16}|[a-zA-Z0-9 \-_+/()&$!,.@]{1,11})$/' // TODO
                ],
            ]);
            $customers = $this->getCustomers($request);
            $text = $request->post('text');

            $smsParams = [];
            foreach (['from'] as $key) {
                $value = $request->post($key);
                if ($value) $smsParams[$key] = $value;
            }

            foreach (['flash', 'performance_tracking'] as $key)
                if ('1' === $request->post($key)) $smsParams[$key] = true;

            $errors = $this->seven->sms($customers, $text, $smsParams);

            if (count($errors)) return redirect()->back();
        }

        return redirect()->back();
    }
}
