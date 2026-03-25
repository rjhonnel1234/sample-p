<?php

namespace App\Http\Controllers;

use Twilio\Rest\Client;
use App\Models\Message;
use Illuminate\Support\Str;
use Illuminate\Http\Request;

class MessageController extends Controller
{
    public function sendForm()
    {
        return view('send');
    }

    public function send(Request $request)
    {
        $request->validate([
            'phone' => 'required',
            'message' => 'required'
        ]);

        try {
            $twilio = new Client(
                env('TWILIO_SID'),
                env('TWILIO_AUTH_TOKEN')
            );

            $twilio->messages->create(
                "whatsapp:" . $request->phone,
                [
                    "from" => env('TWILIO_WHATSAPP_FROM'),
                    "body" => $request->message
                ]
            );

            // Save sent message to database
            Message::create([
                'phone' => $request->phone,
                'message' => $request->message,
                'type' => 'sent'
            ]);

            return back()->with('success', 'Message sent successfully!');

        } catch (\Twilio\Exceptions\RestException $e) {
            return back()->with('error', 'Twilio error: ' . $e->getMessage());

        } catch (\Exception $e) {
            return back()->with('error', 'Something went wrong: ' . $e->getMessage());
        }
    }

    public function webhook(Request $request)
    {
        try {
            Message::create([
                'phone' => Str::replace('whatsapp:', '', $request->From),
                'message' => $request->Body,
                'type' => 'received'
            ]);

            return response('OK', 200);

        } catch (\Exception $e) {
            \Log::error('Webhook error: ' . $e->getMessage());
            return response('Error', 500);
        }
    }

    public function sentMessages()
    {
        try {
            $messages = Message::where('type', 'sent')->latest()->get();
            return view('sent', compact('messages'));
        } catch (\Exception $e) {
            return back()->with('error', 'Failed to load sent messages: ' . $e->getMessage());
        }
    }

    public function inbox()
    {
        try {
            $messages = Message::where('type', 'received')->latest()->get();
            return view('inbox', compact('messages'));
        } catch (\Exception $e) {
            return back()->with('error', 'Failed to load inbox messages: ' . $e->getMessage());
        }
    }
}
