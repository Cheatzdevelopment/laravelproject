<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Foundation\Auth\RegistersUsers;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Auth;

class RegisterController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Register Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles the registration of new users as well as their
    | validation and creation. By default this controller uses a trait to
    | provide this functionality without requiring any additional code.
    |
    */

    use RegistersUsers;

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest');
    }

    /**
     * កំណត់ទិសដៅបន្ទាប់ពីចុះឈ្មោះជោគជ័យ
     *
     * @return string
     */
    public function redirectTo()
    {
        // ជាធម្មតា អ្នកចុះឈ្មោះថ្មីគឺជា User ធម្មតា
        // ប៉ុន្តែយើងដាក់ Logic នេះដើម្បីការពារ ឬសម្រាប់ការពង្រីកថ្ងៃក្រោយ
        $role = Auth::user()->role;

        switch ($role) {
            case 'owner':
                return route('owner.dashboard');
            case 'cashier':
                return route('cashier.dashboard');
            case 'admin':
                return route('admin.dashboard');
            default:
                return route('home'); // User ធម្មតាទៅទំព័រ Home
        }
    }

    /**
     * Get a validator for an incoming registration request.
     *
     * @param  array  $data
     * @return \Illuminate\Contracts\Validation\Validator
     */
    protected function validator(array $data)
    {
        return Validator::make($data, [
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'password' => ['required', 'string', 'min:8', 'confirmed'],
        ]);
    }

    /**
     * Create a new user instance after a valid registration.
     *
     * @param  array  $data
     * @return \App\Models\User
     */
    protected function create(array $data)
    {
        return User::create([
            'name' => $data['name'],
            'email' => $data['email'],
            'password' => Hash::make($data['password']),
            'role' => 'user', // សំខាន់ណាស់! កំណត់ Default Role ជា 'user' ជានិច្ច
        ]);
    }
}
