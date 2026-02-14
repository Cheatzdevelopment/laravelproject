<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\{Auth, Hash, Storage, DB};
use Illuminate\Validation\Rules\Password;

class ProfileController extends Controller
{
    /**
     * បង្ហាញទំព័រសម្រាប់កែប្រែ Profile
     */
    public function edit()
    {
        $user = Auth::user();
        return view('profile.edit', compact('user'));
    }

    /**
     * រក្សាទុកការផ្លាស់ប្តូរឈ្មោះ អ៊ីមែល និងរូបភាព
     */
    public function update(Request $request)
    {
        $user = Auth::user();

        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users,email,' . $user->id,
            'avatar' => 'nullable|image|mimes:jpeg,png,jpg,webp|max:2048',
            'current_password' => 'nullable|required_with:new_password',
            'new_password' => ['nullable', 'confirmed', Password::defaults()],
        ]);

        try {
            DB::beginTransaction();

            $user->name = $request->name;
            $user->email = $request->email;

            // ចាត់ចែងការ Upload រូបភាព
            if ($request->hasFile('avatar')) {
                if ($user->avatar) {
                    Storage::disk('public')->delete($user->avatar);
                }
                $user->avatar = $request->file('avatar')->store('avatars', 'public');
            }

            // កែប្រែ Password
            if ($request->filled('new_password')) {
                if (!Hash::check($request->current_password, $user->password)) {
                    return back()->with('error', 'ពាក្យសម្ងាត់បច្ចុប្បន្នមិនត្រឹមត្រូវទេ!');
                }
                $user->password = Hash::make($request->new_password);
            }

            $user->save();
            DB::commit();

            return back()->with('success', 'ព័ត៌មានគណនីត្រូវបានកែប្រែជោគជ័យ!');
        } catch (\Exception $e) {
            DB::rollBack();
            return back()->with('error', 'មានបញ្ហាបច្ចេកទេស៖ ' . $e->getMessage());
        }
    }

    /**
     * លុបរូបភាព Profile
     */
    public function deleteAvatar()
    {
        $user = Auth::user();
        if ($user->avatar) {
            Storage::disk('public')->delete($user->avatar);
            $user->update(['avatar' => null]);
            return back()->with('success', 'រូបភាព Profile ត្រូវបានលុប!');
        }
        return back()->with('error', 'មិនមានរូបភាពសម្រាប់លុបឡើយ!');
    }
}