<?php

namespace App\Http\Controllers;

use App\Models\Message;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Auth;
use App\Events\MessageSent;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\DB;

class ChatsController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show chats
     *
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View|\Illuminate\Http\Response
     */
    public function index()
    {
        return view('chat');
    }

    /**
     * Fetch all messages
     *
     * @return \Illuminate\Database\Eloquent\Builder[]|\Illuminate\Database\Eloquent\Collection
     */
    public function fetchMessages()
    {
        $user = Auth::user();
        $data = Message::with('user')->where('clear',Message::DONT_CLEAR)->orderBy('created_at', 'desc')->limit(10)->get();
        $count = 0;
        foreach ($data as $item) {
            if ($count === 0) {
                $item->showIcon = true;
            } else {
                $item->showIcon = false;
            }
            $item->user_id === $user->id ? $item->position = 'right' : $item->position = 'left';
            $count++;
        }
        $data = array_values(Arr::sort($data, function ($item) {
            return $item->id;
        }));

        return $data;
    }

    /**
     * Persist message to database
     *
     * @param  Request $request
     * @return string[]
     */
    public function sendMessage(Request $request)
    {
        $user = Auth::user();

        $message = $user->messages()->create([
            'message' => $request->input('message')
        ]);

        broadcast(new MessageSent($user, $message))->toOthers();

        return ['status' => 'Message Sent!'];
    }

    /**
     * Delete message
     *
     * @return string[]
     */
    public function deleteMessage(): array
    {
        DB::table('messages')->where('id','>=', 0)->update(['clear' => Message::CLEAR]);
        return ['status' => 'Message Sent!'];
    }
}
