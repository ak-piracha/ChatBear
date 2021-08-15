<?php

namespace App\Http\Livewire;

use App\Models\Room;
use Hamcrest\Core\IsNot;
use Livewire\Component;

class ChatLists extends Component
{
    
    public $rooms;

    public function mount(Room $room)
    {
        $this->rooms = $room->roomsList();
    }

    public function render()
    {
        return view('livewire.chat-lists');
    }
}
