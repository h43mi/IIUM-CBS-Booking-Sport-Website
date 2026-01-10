<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;

class ContactController extends Controller
{
    public function sendEmail(Request $request)
    {
        // 1. Validate the inputs
        $request->validate([
            'name' => 'required',
            'email' => 'required|email',
            'message' => 'required'
        ]);

        // 2. Prepare the data
        $data = [
            'name' => $request->name,
            'email' => $request->email,
            'user_message' => $request->message // renamed to avoid conflict
        ];

        // 3. Send the email using Laravel's Mail function
        // Note: You need to configure your .env file for this to work!
        Mail::send([], [], function ($message) use ($data) {
            $message->to('mini22killer@gmail.com')
                ->subject('New Contact Form Enquiry')
                ->html("
                <h3>New Enquiry Received</h3>
            <p><strong>Name:</strong> {$data['name']}</p>
            <p><strong>Email:</strong> {$data['email']}</p>
            <p><strong>Message:</strong><br>{$data['user_message']}</p>
            
        ");
        });

        // 4. Redirect back with success message
        return back()->with('success', 'Thank you! Your message has been sent.');
    }
}