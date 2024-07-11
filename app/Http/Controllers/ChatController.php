<?php

namespace App\Http\Controllers;

use App\Events\ChatSent;
use App\Models\Chat;
use Illuminate\Http\Request;

use function Laravel\Prompts\alert;

class ChatController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $messages = Chat::all(); //get all chats
        return view('chat', compact('messages'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $formFields = $request->validate([
            'message' => ['required'],
        ]);
        $chat = Chat::create($formFields); //create a message
        event(new ChatSent($chat->message)); //send the message to the event
        return response()->json(['status' => 'Message sent successfully', 'message' => $chat->message]);
       
    }

    /**
     * Display the specified resource.
     */
    public function show()
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Chat $chat)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Chat $chat)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Chat $chat)
    {
        //
    }
}
