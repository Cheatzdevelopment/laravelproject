<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\ResetsPasswords;
use Illuminate\Support\Facades\Auth;

class ResetPasswordController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Password Reset Controller
    |--------------------------------------------------------------------------
    |
    | This controller is responsible for handling password reset requests
    | and uses a simple trait to include this behavior. You're free to
    | explore this trait and override any methods you wish to tweak.
    |
    */

    use ResetsPasswords;

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        // អនុញ្ញាតឱ្យចូលបានតែ Guest (អ្នកមិនទាន់ Login)
        $this->middleware('guest');
    }

    /**
     * កំណត់ទិសដៅបន្ទាប់ពីប្តូរពាក្យសម្ងាត់ជោគជ័យ (Custom Redirect)
     *
     * @return string
     */
    protected function redirectTo()
    {
        // ក្រោយពេល Reset Password ចប់ Laravel នឹង Login ឱ្យស្វ័យប្រវត្តិ
        // ដូច្នេះយើងអាចឆែកមើល Role បាន
        if (Auth::check()) {
            $role = Auth::user()->role;

            switch ($role) {
                case 'owner':
                    return route('owner.dashboard');
                case 'cashier':
                    return route('cashier.dashboard');
                case 'admin':
                    return route('admin.dashboard');
                default:
                    return route('home');
            }
        }

        // ករណីការពារ៖ បើមិនទាន់ Login ទេ ឱ្យទៅទំព័រដើមសិន
        return route('home');
    }
}
