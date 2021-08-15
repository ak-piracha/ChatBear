<?php

namespace App\Http\Livewire;

use App\Models\Room;
use Hamcrest\Core\IsNot;
use Livewire\Component;
use Illuminate\Support\Facades\Auth;

use function PHPUnit\Framework\isNull;

class ChatLists extends Component
{
    
    public $roomWith;

    public function mount(Room $room)
    {
        $this->roomWith = $room->roomsList();
    }

    public function render()
    {
        return view('livewire.chat-lists', [
            'rooms' => $this->roomWith,
        ]);
    }
}
