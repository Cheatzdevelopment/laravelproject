<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\VerifiesEmails;
use Illuminate\Support\Facades\Auth;

class VerificationController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Email Verification Controller
    |--------------------------------------------------------------------------
    |
    | This controller is responsible for handling email verification for any
    | user that recently registered with the application. Emails may also
    | be re-sent if the user didn't receive the original email message.
    |
    */

    use VerifiesEmails;

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        // តម្រូវឱ្យ Login សិនទើបអាចចូលទំព័រនេះបាន
        $this->middleware('auth');

        // ការពារ Link (Signed URL) សម្រាប់តែ method 'verify'
        $this->middleware('signed')->only('verify');

        // កំណត់ចំនួនដងនៃការចុច (កុំឱ្យចុច Resend ញាប់ពេក)
        $this->middleware('throttle:6,1')->only('verify', 'resend');
    }

    /**
     * កំណត់ទិសដៅបន្ទាប់ពី Verify Email ជោគជ័យ
     *
     * @return string
     */
    protected function redirectTo()
    {
        // បន្ទាប់ពី Verify ជោគជ័យ យើងពិនិត្យមើល Role ដើម្បីបញ្ជូនទៅកន្លែងត្រូវ
        $role = Auth::user()->role;

        switch ($role) {
            case 'owner':
                return route('owner.dashboard');
            case 'cashier':
                return route('cashier.dashboard');
            case 'admin':
                return route('admin.dashboard');
            default:
                // សម្រាប់ User ធម្មតា បញ្ជូនទៅទំព័រដើម ឬទំព័រដែលគាត់ចង់ទៅពីមុន
                return route('home');
        }
    }
}
