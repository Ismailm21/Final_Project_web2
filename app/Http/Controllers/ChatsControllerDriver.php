<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Chats;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;

class ChatsControllerDriver extends Controller
{


    public function index()
    {
        // Retrieve the authenticated user's role
        $authUserRole = Auth::user()->role;

        // Fetch users based on the authenticated user's
        //If user is a client, it fetches all drivers         `
        //If user is a driver, it fetches all clients.
        //If user is neither (like an admin), it fetches both.
        if ($authUserRole === 'client') {
            $users = User::where('role', 'driver')->select('id', 'name')->get();
        } elseif ($authUserRole === 'driver') {
            $users = User::where('role', 'client')->select('id', 'name')->get();
        } else {
            $users = User::whereIn('role', ['client', 'driver'])->select('id', 'name')->get();
        }

        return view('driver.chats', compact('users'));
    }

    public function sendMessage(Request $request)
    {
        //Log::info('sendMessage called', $request->all());

        $item = new Chats();
        $item->date_time = now();
        $item->sender_id = Auth::user()->id;
        $item->receiver_id = $request->user;
        $item->message_type = 'text';
        $item->message = e($request->input('message'));
        $item->is_received = false;
        $item->save();

        return $item;
    }



    public function getChatHistory(Request $request)
    {
        $messages = Chats::with('sender')
            ->where(function ($query) use ($request) {
                $query->where('sender_id', Auth::user()->id)
                    ->where('receiver_id', $request->userID);
            })
            ->orWhere(function ($query) use ($request) {
                $query->where('sender_id', $request->userID)
                    ->where('receiver_id', Auth::user()->id);
            })
            ->orderBy('date_time', 'asc')
            ->get();

        foreach ($messages->where('receiver_id', Auth::user()->id) as $message) {
            $message->is_received = 1;
            $message->update();
        }
        return $messages;
    }


    public function getNewMessages($user_id)
    {
        $message = Chats::where('receiver_id', Auth::user()->id)
            ->where('sender_id', $user_id)
            ->where('is_received', 0)
            ->with('sender')
            ->first();

        header('Content-Type: text/event-stream');
        header('Cache-Control: no-cache');
        header('Connection: keep-alive');

        if ($message) {
            $eventData = [
                'item' => $message,
            ];

            echo "data:" . json_encode($eventData) . "\n\n";
            $message->is_received = 1;
            $message->update();
        } else {
            echo "\n\n";
        }

        ob_flush();
        flush();
    }
}
