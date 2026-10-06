<?php

namespace App\Http\Controllers;

use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
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

        $text = "Bonjour WattLoc, message depuis le site.\nNom : {$data['name']}\nTél : {$data['phone']}\n{$data['message']}";

        return redirect()->away(whatsapp_url($text));
    }
}
