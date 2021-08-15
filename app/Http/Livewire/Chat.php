<?php

namespace App\Http\Livewire;

use App\Models\Room;
use App\Models\Message;
use Carbon\Carbon;
use Livewire\Component;
use Illuminate\Support\Facades\Auth;

class Chat extends Component
{
    public $userId;
    public $messageText;
    public $chats;
    public $chatWith;
    public $room;

    public function mount(Room $room)
    {
        $this->room = $room;
        $this->userId = Auth::user();
    }

    public function render()
    {
        $messages = Message::with(relations: 'user')
        ->where('room_id', '=', $this->room->getRoomId()->id)
        ->latest()
        ->take(value: 10)
        ->get()
        ->sortBy(callback: 'id');

        return view('livewire.chat' , compact(var_name:'messages'));
    }

    public function sendMessage(Room $room)
    {
        //DB::insert('insert into messages (id, name) values (?, ?)', [1, 'Dayle'])
        Message::create([
            'room_id' => $room->getRoomId()->id,
            'user_id' => $this->userId->id,
            'message' => $this->messageText,
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now(),
        ]);

        $this->reset('messageText');
    }

    // public function chatWith(Participant $participant)
    // {
    //     $this->chatWith = $participant->user()->
    // }
}
