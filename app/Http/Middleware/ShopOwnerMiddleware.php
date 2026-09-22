<?php

namespace App\Http\Middleware;

use App\Enums\VerificationStatus;
use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class ShopOwnerMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  Closure(Request): (Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        if (! Auth::check() || ! Auth::user()->hasRole('owner')) {
            abort(404, 'Unauthorized');
        }

        $user = Auth::user();
        $tenant = $user->tenant;

        if ($request->routeIs('owner.business_setup') || $request->routeIs('owner.business_status')) {
            return $next($request);
        }

        if (! $tenant || ! $tenant->business_setup_completed) {
            return redirect()->route('owner.business_setup');
        }

        if ($tenant->verification_status === VerificationStatus::Rejected->value) {
            return redirect()->route('owner.business_status');
        }

        if ($tenant->verification_status !== VerificationStatus::Approved->value || ! $tenant->is_active) {
            return redirect()->route('owner.business_status');
        }

        return $next($request);
    }
}
