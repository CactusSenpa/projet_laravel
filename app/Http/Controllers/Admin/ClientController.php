<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rule;
use Illuminate\View\View;

class ClientController extends Controller
{
    public function index(): View
    {
        $clients = User::query()
            ->where('role', 'customer')
            ->withCount('reservations')
            ->latest()
            ->paginate(20);

        return view('admin.clients.index', compact('clients'));
    }

    public function create(): View
    {
        return view('admin.clients.create');
    }

    public function store(Request $request): RedirectResponse
    {
        $data = $this->validated($request);
        $data['password'] = Hash::make($data['password']);
        $data['role'] = 'customer';
        $data['is_active'] = $request->boolean('is_active', true);

        $client = User::query()->create($data);
        $client->sendEmailVerificationNotification();

        return redirect()->route('admin.clients.index')->with('success', 'Client créé.');
    }

    public function edit(User $client): View
    {
        $this->ensureClient($client);

        return view('admin.clients.edit', compact('client'));
    }

    public function update(Request $request, User $client): RedirectResponse
    {
        $this->ensureClient($client);
        $data = $this->validated($request, $client);
        $emailChanged = $data['email'] !== $client->email;

        if (! empty($data['password'])) {
            $data['password'] = Hash::make($data['password']);
        } else {
            unset($data['password']);
        }

        $data['is_active'] = $request->boolean('is_active');
        if ($emailChanged) {
            $client->forceFill(['email_verified_at' => null])->save();
        }
        $client->update($data);
        $client->refresh();

        if ($emailChanged || ! $client->hasVerifiedEmail()) {
            $client->sendEmailVerificationNotification();
        }

        return redirect()->route('admin.clients.index')->with('success', 'Client mis à jour.');
    }

    public function destroy(User $client): RedirectResponse
    {
        $this->ensureClient($client);
        $client->delete();

        return back()->with('success', 'Client supprimé. Ses réservations sont conservées.');
    }

    private function validated(Request $request, ?User $client = null): array
    {
        return $request->validate([
            'name' => ['required', 'string', 'max:120'],
            'email' => ['required', 'email', 'max:255', Rule::unique('users', 'email')->ignore($client)],
            'phone' => ['nullable', 'string', 'max:30'],
            'password' => [$client ? 'nullable' : 'required', 'string', 'min:8', 'confirmed'],
        ]);
    }

    private function ensureClient(User $client): void
    {
        abort_unless($client->role === 'customer', 404);
    }
}
