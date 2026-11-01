<?php
namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class EnsureMitra
{
    public function handle(Request $request, Closure $next)
    {
        $user = $request->user();
        abort_unless($user?->isMitra() && $user->mitra, 403, 'Halaman ini hanya untuk mitra.');
        return $next($request);
    }
}
