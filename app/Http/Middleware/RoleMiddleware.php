<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class RoleMiddleware
{
    public function handle(Request $request, Closure $next, string ...$roles): Response
    {
        // ១. បើមិនទាន់ Login ឱ្យទៅទំព័រ Login
        if (!Auth::check()) {
            return redirect()->route('login');
        }

        $user = Auth::user();

        // ២. Master Access: បើជា Owner គឺអាចទៅមុខបានទាំងអស់ (Bypass គ្រប់លក្ខខណ្ឌ)
        if ($user->role === 'owner') {
            return $next($request);
        }

        // ៣. ពិនិត្យមើល Role របស់ User ធៀបនឹងបញ្ជីដែលអនុញ្ញាតក្នុង Route
        if (in_array($user->role, $roles)) {
            return $next($request);
        }

        // ៤. បើគ្មានសិទ្ធិ បោះ Error 403
        abort(403, 'សុំទោស! អ្នកមិនមានសិទ្ធិចូលប្រើប្រាស់ទំព័រនេះទេ។');
    }
}