<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class ContactController extends Controller
{
    public function submit(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'surname' => 'required|string|max:255',
            'email' => 'required|email|max:255',
            'message' => 'required|string|max:2000',
        ]);

        //placeholder -- todo:add logic for email sending and insertion into database

        return back()->with('success', 'Votre message a été envoyé avec succès! Nous vous répondrons dans les plus brefs délais.');
    }
}
