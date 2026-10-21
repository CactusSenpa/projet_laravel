<?php

namespace App\Http\Controllers;

use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use Illuminate\View\View;

class ContactController extends Controller
{
    public function index(): View
    {
        return view('contact.index');
    }

    public function send(Request $request): RedirectResponse
    {
        $data = $request->validate([
            'name' => 'required|string|max:120',
            'phone' => 'required|string|max:30',
            'email' => 'nullable|email',
            'message' => 'required|string|max:2000',
        ]);

        $text = "Bonjour WattLoc, message depuis le site.\n"
            ."Nom : {$data['name']}\n"
            ."Tél : {$data['phone']}\n"
            ."E-mail : ".($data['email'] ?? 'Non renseigné')."\n\n"
            ."Message :\n{$data['message']}";

        Mail::raw($text, function ($mail) use ($data): void {
            $mail->to(config('mail.from.address'))
                ->subject('Nouveau message depuis le formulaire de contact');

            if (! empty($data['email'])) {
                $mail->replyTo($data['email'], $data['name']);
            }
        });

        return redirect()
            ->route('contact')
            ->with('status', 'Votre message a bien été envoyé.');
    }
}
