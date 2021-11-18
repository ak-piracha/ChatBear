<?php

namespace App\Http\Livewire;

use DateTime;
use Carbon\Carbon;
use App\Models\Room;
use App\Models\Message;
use Livewire\Component;
use Livewire\WithPagination;
use Livewire\WithFileUploads;
use App\Models\message_statuses;
use Illuminate\Foundation\Auth\User;
use Illuminate\Support\Facades\Auth;

class Chat extends Component
{
    public $first_user;
    public $second_user;
    public $chat_room;
    public $message_text;
    public $room;
    public $response;
    public $message_status;
    public $photo;
    public $date;
    public $interval;

    use WithPagination;
    use WithFileUploads;

    public function mount($id)
    {
        $this->date = Carbon::now();
        $this->room = new Room();
        $this->message_status = message_statuses::find(1);
        $this->chat_room = Room::find($id);
        $this->first_user = Auth::user();
        $this->second_user = $this->room->secondUser($this->chat_room);
        $this->interval = $this->timeDifference();

    }

    public function render()
    {

        Message::where('room_id', '=', $this->chat_room->id)
        ->where('user_id', '=', $this->second_user->id)
        ->update(['status'=> $this->message_status->id]);

        return view('livewire.chat', [
            'messages' => Message::with('user')
            ->where('room_id', '=', $this->chat_room->id)
            ->latest()
            ->paginate(6),
        ]);
    }

    public function timeDifference()
    {
        $origin = new DateTime($this->second_user->last_seen);
        $target = new DateTime($this->date);
        $interval = $origin->diff($target);

        return  $interval->format("%H:%I:%S");
    }

    public function sendMessage()
    {
        if(!(is_null($this->message_text))) {
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

    public function save()
    {
        $this->validate([
            'photo' => 'image|max:1024', // 1MB Max
        ]);

        $this->photo->store('photos');
    }

}
