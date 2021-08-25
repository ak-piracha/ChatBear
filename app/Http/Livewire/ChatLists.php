<?php

namespace App\Http\Livewire;

use DateTime;
use Carbon\Carbon;
use App\Models\Room;
use Livewire\Component;
use App\Models\RoomType;
use Hamcrest\Core\IsNot;
use Livewire\WithPagination;    
use Illuminate\Foundation\Auth\User;
use Illuminate\Support\Facades\Auth;

class ChatLists extends Component
{
    use WithPagination;
    public $room_name;
    public $search = "";
    public $second_user;

    protected $listeners = ['selectedUser'];

    public function mount()
    {
        
    }

    public function render()
    {
        return view('livewire.chat-lists', [
            'rooms' => Room::where('user_b_id', '=', Auth::user()->id)
            ->orWhere('user_a_id', '=', Auth::user()->id)->paginate(6),
            'users' => User::where('name','like', $this->search . '%' )->get(),
        ]);
        
        $this->reset('search'); 
    }

    public function addRoom(Room $room)
    {   
        $room->addRoom($this->room_name,$this->second_user);
        $this->reset('room_name'); 
    }

    public function timeDifference()
    {
        $origin = new DateTime($this->second_user->last_seen);
        $target = new DateTime($this->date);
        $interval = $origin->diff($target);
       
        return  $interval->format("%H:%I:%S");
    }

    public function selectedUser(User $user)
    {
        $this->second_user = $user;
        $this->reset('search'); 
    }
    
}
