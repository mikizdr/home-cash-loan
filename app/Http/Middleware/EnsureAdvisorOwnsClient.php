<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use Symfony\Component\HttpFoundation\Response;

class EnsureAdvisorOwnsClient
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        $client = $request->route('client');

        if ($client && Auth::check() && Auth::user()->advisorOwnsClient($client->id)) {
            return $next($request);
        }

        if (Auth::check() && Auth::user()->isAdvisor() && Route::is(['clients.index', 'clients.create', 'advisor.report'])) {
            return $next($request);
        }

        $route = 'dashboard';
        $message = __('You do not have permissions for this operation.');

        if (Auth::check() && Auth::user()->isAdvisor()) {
            $route = 'clients.index';
            $message = __('You do not own this client.');
        }

        return redirect()->route($route)
            ->with('client-error', $message);
    }
}
