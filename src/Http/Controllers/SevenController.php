<?php

namespace Seven\Bagisto\Http\Controllers;

use Illuminate\Http\RedirectResponse;
use Illuminate\Routing\Controller;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\View\View;
use Seven\Bagisto\Services\Seven;

class SevenController extends Controller {
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;

    public function __construct(protected Seven $seven) {}

    /**
     * Display a listing of the resource.
     */
    public function index(): View {
        return view('seven::index', ['entityType' => 'customers']);
    }

    /**
     * Compose SMS for destined for a single customer.
     */
    public function smsCustomer(int $id): View {
        return $this->sms('customers', $id);
    }

    /**
     * Compose SMS for destined for a single customer group.
     */
    public function smsCustomerGroup(int $id): View {
        return $this->sms('customerGroups', $id);
    }

    protected function sms(string $entityType, int $id): View {
        return view('seven::sms', compact('entityType', 'id'));
    }

    public function smsSend(): RedirectResponse {
        $request = request();

        if ($request->method() === 'POST') {
            $errors = $this->seven->sms($request);

            if (count($errors)) return redirect()->back();
        }

        return redirect()->back();
    }
}
