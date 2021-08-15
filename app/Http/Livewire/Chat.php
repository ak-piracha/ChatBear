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
    public $user;
    public $messageText;
    public $chatsWith;
    public $room;

    public function mount(Room $room)
    {

        $this->room = $room;
        $this->user = Auth::user();
        $this->chatsWith = $room->conversationRoom($this->user)->name;
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
            'room_id' => $room->getConversationWith()->id,
            'user_id' => $this->user->id,
            'message' => $this->messageText,
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now(),
        ]);

        $this->reset('messageText');
    }

}
