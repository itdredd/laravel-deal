<?php

namespace App\Http\Controllers;

use App\Http\Requests\ProfileUpdateRequest;
use App\Models\User;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;
use Inertia\Inertia;

class ProfileController extends Controller
{
    /**
     * Display the user's profile form.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Inertia\Response
     */
    public function edit(Request $request) {
        return Inertia::render('Profile/Edit', [
            'mustVerifyEmail' => $request->user() instanceof MustVerifyEmail,
            'status' => session('status'),
        ]);
    }

    /**
     * Update the user's profile information.
     *
     * @param \App\Http\Requests\ProfileUpdateRequest $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function update(ProfileUpdateRequest $request) {
        $request->user()->fill($request->validated());

        if ($request->user()->isDirty('email')) {
            $request->user()->email_verified_at = null;
        }

        $request->user()->save();

        return Redirect::route('profile.edit');
    }

    /**
     * Delete the user's account.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function destroy(Request $request) {
        return Redirect::route('profile.edit');
        /*$request->validate([
            'password' => ['required', 'current-password'],
        ]);

        $user = $request->user();

        Auth::logout();

        $user->delete();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return Redirect::to('/');*/
    }

    public function avatar(Request $request) {
        if ($request->hasFile('avatar')) {
            $filename = $request->avatar->getClientOriginalName();
            $request->avatar->storeAs('avatars', $filename, 'public');
            Auth()->user()->update(['avatar' => $filename]);
        }
        return redirect()->back();
    }

    public function changeLang() {
        $user = User::find(Auth::id());
        $user->language == 'en' ? $user->language = 'ru' : $user->language = 'en';
        $user->save();

        return Redirect::route('deal.list');
    }
}
