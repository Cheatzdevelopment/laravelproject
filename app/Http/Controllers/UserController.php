<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;

class UserController extends Controller
{
    /**
     * បង្ហាញបញ្ជីអ្នកប្រើប្រាស់ទាំងអស់ (លើកលែងតែខ្លួនឯង)
     */
    public function index()
    {
        // ទាញយក Users ទាំងអស់ ប៉ុន្តែកុំយកគណនីដែលកំពុង Login (Owner ខ្លួនឯង)
        // ដើម្បីការពារកុំឱ្យច្រឡំដៃលុបគណនីខ្លួនឯងចោល
        $users = User::where('id', '!=', Auth::id())
                     ->orderBy('created_at', 'desc') // បង្ហាញអ្នកថ្មីនៅលើគេ
                     ->get();

        return view('owner.users.index', compact('users'));
    }

    /**
     * បង្កើតគណនីថ្មី (Create User/Staff)
     */
    public function store(Request $request)
    {
        // ១. ផ្ទៀងផ្ទាត់ទិន្នន័យ (Validation)
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users', // អ៊ីមែលមិនអាចជាន់គ្នាបានទេ
            'password' => 'required|string|min:8', // លេខសម្ងាត់យ៉ាងតិច ៨ ខ្ទង់
            'role' => 'required|in:admin,cashier,user', // ហាមដាក់ role ផ្សេងក្រៅពីនេះ
        ]);

        // ២. បង្កើត User ចូល Database
        User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password), // កូដសម្ងាត់ត្រូវតែ Hash (សុវត្ថិភាព)
            'role' => $request->role,
        ]);

        return back()->with('success', 'គណនីបុគ្គលិកថ្មីត្រូវបានបង្កើតជោគជ័យ!');
    }

    /**
     * លុបគណនី (Delete User)
     */
    public function destroy($id)
    {
        $user = User::findOrFail($id);

        // សុវត្ថិភាពបន្ថែម: ហាមលុបគណនីដែលជា Owner ដូចគ្នា (ការពារកំហុស)
        if ($user->role === 'owner') {
            return back()->with('error', 'មិនអនុញ្ញាតឱ្យលុបគណនី Owner ទេ!');
        }

        $user->delete();

        return back()->with('success', 'គណនីត្រូវបានលុបចេញពីប្រព័ន្ធ!');
    }
}
