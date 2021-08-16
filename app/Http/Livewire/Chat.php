<?php

namespace App\Http\Livewire;

use Carbon\Carbon;
use App\Models\Room;
use App\Models\Message;
use Livewire\Component;
use Illuminate\Foundation\Auth\User;
use Illuminate\Support\Facades\Auth;

class Chat extends Component
{
    public $first_user;
    public $second_user;
    public $chat_room;
    public $message_text;
    public $room;

    public function mount($id)
    {
        $this->room = new Room();

        $this->chat_room = Room::find($id);
        $this->first_user = Auth::user();
        $this->second_user = $this->room->secondUser($this->chat_room);
    }

    public function render()
    {
        $messages = Message::with(relations: 'user')
        ->where('room_id', '=', $this->chat_room->id)
        ->latest()
        ->take(value: 10)
        ->get()
        ->sortBy(callback: 'id');
        
        return view('livewire.chat' , compact(var_name:'messages'));
    }

    public function sendMessage()
    {
        Message::create([
            'room_id' => $this->chat_room->id,
            'user_id' => $this->first_user->id,
            'message' => $this->message_text,
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now(),
        ]);

        $this->reset('message_text');
    }

}
