<?php

namespace App\Http\Controllers\Tenant;

use App\Models\SubscriptionPlan;
use Illuminate\Routing\Controller;

class PlansController extends Controller
{
    public function index()
    {
        $plans = SubscriptionPlan::where('is_public', true)
            ->where('is_active', true)
            ->orderBy('sort_order')
            ->get();

        return view('tenant.plans', ['plans' => $plans]);
    }
}
