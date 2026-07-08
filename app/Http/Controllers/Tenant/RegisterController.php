<?php

namespace App\Http\Controllers\Tenant;

use App\Models\SubscriptionPlan;
use App\Services\TenantService;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Hash;
use App\Models\User;

class RegisterController extends Controller
{
    public function show()
    {
        $plans = SubscriptionPlan::where('is_public', true)->where('is_active', true)->orderBy('sort_order')->get();
        return view('tenant.register', ['plans' => $plans]);
    }

    public function store(Request $request, TenantService $service)
    {
        $validated = $request->validate([
            'business_name' => 'required|string|max:255',
            'slug' => 'required|alpha_dash|max:100|unique:tenants,slug',
            'email' => 'required|email|max:255',
            'phone' => 'nullable|string|max:30',
            'name' => 'required|string|max:255',
            'user_email' => 'required|email|unique:users,email',
            'password' => 'required|min:8|confirmed',
            'plan_slug' => 'nullable|string|exists:subscription_plans,slug',
        ]);

        $plan = SubscriptionPlan::where('slug', $request->plan_slug ?? 'free')->first();

        $tenant = $service->create([
            'name' => $validated['business_name'],
            'slug' => $validated['slug'],
            'email' => $validated['email'],
            'phone' => $validated['phone'] ?? null,
        ]);

        if ($plan) {
            $tenant->subscription_plan_id = $plan->id;
            $tenant->max_outlets = $plan->max_outlets;
            $tenant->max_users = $plan->max_users;
            $tenant->max_products = $plan->max_products;
            $tenant->max_transactions_per_day = $plan->max_transactions_per_day;
            $tenant->save();
        }

        $user = User::create([
            'name' => $validated['name'],
            'email' => $validated['user_email'],
            'password' => Hash::make($validated['password']),
            'role' => 'owner',
            'tenant_id' => $tenant->id,
        ]);

        $user->roles()->sync([\App\Models\Role::where('slug', 'owner')->first()?->id]);

        auth()->login($user);

        return redirect('/admin')->with('success', 'Selamat datang di ERPAsia! Silakan setup toko Anda.');
    }
}
