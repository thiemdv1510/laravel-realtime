<?php

namespace App\Http\Controllers;

use App\Models\Message;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Auth;
use App\Events\MessageSent;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Nette\Utils\Image;

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
            $item->date = date('H:i:s d-m-y ', strtotime($item->created_at));
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
        date_default_timezone_set('Asia/Ho_Chi_Minh');
        $message = $user->messages()->create([
            'message' => $request->input('message'),
            'type'=> $request->input('type')
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
        date_default_timezone_set('Asia/Ho_Chi_Minh');

        DB::table('messages')->where('id','>=', 0)
            ->update(['clear' => Message::CLEAR, 'clear_date' => date('Y-m-d H:i:s')]);

        return ['status' => 'Message Sent!'];
    }

    /**
     * Delete message
     *
     * @return string[]
     */
    public function updateRead(Request $request): array {
        $user = Auth::user();
        $user_id = $user->id;
        $record = DB::table('messages')
            ->where('user_id', '<>',$user_id)
            ->where('message', $request->get('message'))
            ->update(['read' => Message::READ, 'read_date' => date('Y-m-d H:i:s')]);

        return ['status' => 'Message Sent!'];
    }

    public function uploadImage(Request $request) {
        $user = Auth::user();

        $file = $request->file('imageUpload');
        $fileName =  time() . '.' . $file->getClientOriginalExtension();
        $file->move('images', $fileName);
        date_default_timezone_set('Asia/Ho_Chi_Minh');

        $message = $user->messages()->create([
            'message' => $fileName,
            'type' => Message::TYPE_IMAGE,
            'clear' => Message::CLEAR
        ]);

        return true;
    }

    public function getLastMessageByUser(Request $request): \Illuminate\Http\JsonResponse
    {
        $item = DB::table('messages')->where('user_id', $request->get('userId'))->orderBy('id', 'DESC')->first();
        return \response()->json(['name'=>$item->message]);
    }
}
