<?php

namespace App\Http\Middleware;

use App\Enums\UserRole;
use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class EnsureUserHasRole
{
    /**
     * @param  Closure(Request): Response  $next
     */
    public function handle(Request $request, Closure $next, string ...$roles): Response
    {
        $user = $request->user();

        if (! $user) {
            abort(403);
        }

        $allowedRoles = collect($roles)
            ->map(fn (string $role): string => UserRole::tryFrom($role)?->value ?? $role)
            ->all();

        if (! $user->hasRole(...$allowedRoles)) {
            abort(403);
        }

        return $next($request);
    }
}
