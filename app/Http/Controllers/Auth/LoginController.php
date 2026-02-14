<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Support\Facades\Auth;

class LoginController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Login Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles authenticating users for the application and
    | redirecting them to your home screen. The controller uses a trait
    | to conveniently provide its functionality to your applications.
    |
    */

    use AuthenticatesUsers;

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest')->except('logout');
        $this->middleware('auth')->only('logout');
    }

    /**
     * កំណត់ទិសដៅបន្ទាប់ពី Login ជោគជ័យ (Custom Redirection Logic)
     * Function នេះនឹងជំនួស $redirectTo property
     *
     * @return string
     */
    public function redirectTo()
    {
        // ទទួលបានតួនាទីរបស់អ្នកប្រើប្រាស់ដែលទើបតែ Login
        $role = Auth::user()->role;

        // ពិនិត្យមើល និងបញ្ជូនទៅតាមតួនាទី
        switch ($role) {
            case 'owner':
                return route('owner.dashboard'); // ឬ '/owner/dashboard'

            case 'cashier':
                return route('cashier.dashboard'); // ឬ '/cashier/dashboard'

            case 'admin':
                return route('admin.dashboard'); // ឬ '/admin/dashboard'

            default:
                // សម្រាប់ User ធម្មតា ឬ role ផ្សេងៗ
                return route('home'); // ឬ '/'
        }
    }
}
