<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\ConfirmsPasswords;
use Illuminate\Support\Facades\Auth;

class ConfirmPasswordController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Confirm Password Controller
    |--------------------------------------------------------------------------
    |
    | This controller is responsible for handling password confirmations and
    | uses a simple trait to include the behavior. You're free to explore
    | this trait and override any functions that require customization.
    |
    */

    use ConfirmsPasswords;

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        // តម្រូវឱ្យ Login រួចរាល់សិន ទើបប្រើ Controller នេះបាន
        $this->middleware('auth');
    }

    /**
     * កំណត់ទិសដៅបន្ទាប់ពីបញ្ជាក់ពាក្យសម្ងាត់ជោគជ័យ
     *
     * @return string
     */
    public function redirectTo()
    {
        // តាមធម្មតា Laravel នឹងបញ្ជូនទៅ URL ដែល User ចង់ទៅដោយស្វ័យប្រវត្តិ (Intended URL)
        // ប៉ុន្តែបើគ្មាន Intended URL ទេ យើងនឹងប្រើ Logic ខាងក្រោម៖

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

        return route('home');
    }
}
