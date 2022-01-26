<?php

namespace Sms77\Bagisto\Http\Controllers;

use Illuminate\Http\RedirectResponse;
use Illuminate\Routing\Controller;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\View\View;
use Sms77\Bagisto\Services\Sms77;

class Sms77Controller extends Controller {
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;

    /** @var Sms77 $sms77 */
    protected Sms77 $sms77;

    /**
     * @param Sms77 $sms77
     */
    public function __construct(Sms77            $sms77) {
        $this->sms77 = $sms77;
    }

    /**
     * Display a listing of the resource.
     * @return View
     */
    public function index(): View {
        return view('sms77::index', ['entityType' => 'customers']);
    }

    /**
     * Compose SMS for destined for a single customer.
     * @param int $id
     * @return View
     */
    public function smsCustomer(int $id): View {
        return $this->sms('customers', $id);
    }

    /**
     * Compose SMS for destined for a single customer group.
     * @param int $id
     * @return View
     */
    public function smsCustomerGroup(int $id): View {
        return $this->sms('customerGroups', $id);
    }

    /**
     * @param string $entityType
     * @param int $id
     * @return View
     */
    protected function sms(string $entityType, int $id): View {
        return view('sms77::sms', compact('entityType', 'id'));
    }

    public function smsSend(): RedirectResponse {
        $request = request();

        if ($request->method() === 'POST') {
            $errors = $this->sms77->sms($request);

            if (count($errors)) return redirect()->back();
        }

        return redirect()->back();
    }
}
