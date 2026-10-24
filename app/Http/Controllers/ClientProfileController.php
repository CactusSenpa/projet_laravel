<?php

namespace App\Http\Controllers;

use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\View\View;

class ClientProfileController extends Controller
{
    public function edit(Request $request): View
    {
        return view('client.profile', ['user' => $request->user()]);
    }

    public function update(Request $request): RedirectResponse
    {
        $user = $request->user();
        $data = $request->validate([
            'name' => ['required', 'string', 'max:120'],
            'email' => ['required', 'email', 'max:255', 'unique:users,email,'.$user->id],
            'phone' => ['nullable', 'string', 'max:30'],
            'profile_photo' => ['nullable', 'image', 'max:2048'],
        ]);

        if ($request->hasFile('profile_photo')) {
            if ($user->profile_photo) {
                Storage::disk('public')->delete($user->profile_photo);
            }
            $data['profile_photo'] = $request->file('profile_photo')->store('profile-photos', 'public');
        }

        $user->update($data);

        return back()->with('success', 'Profil mis à jour.');
    }

    public function reservations(Request $request): View
    {
        $user = $request->user();
        $reservations = $user->reservations()
            ->with(['pack', 'products.product'])
            ->latest()
            ->paginate(10);
        $clientReservationNumbers = $user->reservations()
            ->orderBy('created_at')
            ->orderBy('id')
            ->pluck('id')
            ->flip()
            ->map(fn (int $number): int => $number + 1);

        return view('client.reservations', compact('reservations', 'clientReservationNumbers'));
    }
}
