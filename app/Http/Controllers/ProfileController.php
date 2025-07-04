<?php

namespace App\Http\Controllers;

use App\Http\Requests\ProfileRequest;
use App\Models\User;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;
use Illuminate\View\View;
use Illuminate\Validation\Rules\Password;
use Illuminate\Support\Facades\Hash;



class ProfileController extends Controller
{
    /**
     * Display the user's profile form.
     */
    public function index(): View
    {
        return view('profile.edit', [
            'user' => Auth::user(),
        ]);
    }

    public function updatePhoto(User $user, Request $request)
    {
        //$user = Auth::user();

        $request->validate([
            'profile_photo' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        // Verificar si se ha subido un archivo
        if ($request->hasFile('profile_photo')) {
            // Añade la nueva foto
            $user->addMedia($request->file('profile_photo'))->toMediaCollection('profile_photos');
        }

        return redirect()->back()->with('update_photo_success', 'Foto de perfil actualizada');
    }

    public function deletePhoto(User $user)
    {
        // Eliminar la foto de perfil
        $user->clearMediaCollection('profile_photos');

        return redirect()->back()->with('status', 'Foto de perfil eliminada');
    }

    /**
     * Update the user's profile information.
     */
    public function updateProfile(ProfileRequest $profileRequest): RedirectResponse
    {
        $profileRequest->user()->fill($profileRequest->validated());

        if ($profileRequest->user()->isDirty('email')) {
            $profileRequest->user()->email_verified_at = null;
        }

        $profileRequest->user()->save();

        return redirect()->route('profile.edit')->with('status', 'profile-updated');
    }

    public function updatePassword(ProfileRequest $request): RedirectResponse
    {
        $validated = $request->validateWithBag('updatePassword', [
            'current_password' => ['required', 'current_password'],
            'password' => ['required', Password::defaults(), 'confirmed'],
        ]);

        $request->user()->update([
            'password' => Hash::make($validated['password']),
        ]);

        return back()->with('status', 'password-updated');
    }

    /**
     * Delete the user's account.
     */
    public function destroy(ProfileRequest $request): RedirectResponse
    {
        $request->validateWithBag('userDeletion', [
            'password' => ['required', 'current_password'],
        ]);

        $user = $request->user();

        Auth::logout();

        $user->delete();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return Redirect::to('/');
    }

}
