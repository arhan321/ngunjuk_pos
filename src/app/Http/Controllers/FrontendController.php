<?php

declare(strict_types=1);

namespace App\Http\Controllers;

use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Validation\Rules\Password;
use Illuminate\View\View;

class FrontendController extends Controller
{
    public function login(): View
    {
        return view('login');
    }

    public function settings(): View
    {
        $user = auth()->user();

        $userRole = $user->getRoleNames()->first() ?? '-';

        return view('settings', [
            'user' => $user,
            'userRole' => $userRole,
        ]);
    }

    public function updatePassword(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'password' => [
                'required',
                'confirmed',
                Password::min(8)
                    ->letters()
                    ->mixedCase()
                    ->numbers(),
            ],
        ], [
            'password.required' => 'Password baru wajib diisi.',
            'password.confirmed' => 'Konfirmasi password tidak sama dengan password baru.',
            'password.min' => 'Password minimal harus terdiri dari 8 karakter.',
            'password.letters' => 'Password harus memiliki minimal satu huruf.',
            'password.mixed' => 'Password harus memiliki huruf besar dan huruf kecil.',
            'password.numbers' => 'Password harus memiliki minimal satu angka.',
        ]);

        $request->user()->update([
            'password' => $validated['password'],
        ]);

        $request->session()->regenerate();

        return redirect()
            ->route('frontend.settings')
            ->with('success', 'Password berhasil diperbarui. Gunakan password baru saat login berikutnya.');
    }
}