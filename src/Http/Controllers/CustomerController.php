<?php

namespace Seven\Bagisto\Http\Controllers;

use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Seven\Bagisto\Services\RequestHandler;
use Seven\Bagisto\Services\Seven;
use Webkul\Customer\Models\Customer;
use Webkul\Customer\Repositories\CustomerRepository;

class CustomerController extends Controller {
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;

    public function __construct(
        protected Seven $seven,
        protected CustomerRepository $customerRepository
    ) {}

    protected function getCustomer(Request $request): ?Customer {
        $id = $request->post('id');
        if (null === $id) {
            $previousUrl = $request->session()->previousUrl();
            $parts = explode('/', $previousUrl);
            $id = array_pop($parts);
        }

        return $id ? $this->customerRepository->find($id) : null;
    }

    public function sms(): RedirectResponse {
        $request = request();

        if ($request->method() === 'POST') {
            $requestHandler = new RequestHandler($request);
            $requestHandler->validateSmsParams();

            $errors = $this->seven->sms([$this->getCustomer($request)], $requestHandler->buildSmsParams());

            if (count($errors)) return redirect()->back();
        }

        return redirect()->back();
    }
}
