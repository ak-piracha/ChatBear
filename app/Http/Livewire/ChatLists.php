<?php

namespace App\Http\Livewire;

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
            'users' => User::where('name', $this->search)->get(),
        ]);
        
        $this->reset('search'); 
    }

    public function addRoom()
    {   
        Room::create([
            'name' => $this->room_name,
            'user_a_id' => Auth::user()->id,
            'user_b_id' => $this->second_user->id,
            'type_id' => RoomType::find(1)->id,
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now(),
        ]);
        
        $this->reset('room_name'); 
    }

    public function selectedUser(User $user)
    {
        $this->second_user = $user;
        $this->reset('search'); 
    }
    
}
