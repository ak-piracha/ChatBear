<?php

namespace App\Http\Livewire;

use Carbon\Carbon;
use App\Models\Message;
use Livewire\Component;
use Livewire\WithPagination;
use App\Models\MessageStatus;
use App\Models\User;
use Illuminate\Support\Facades\Auth;

class Chat extends Component
{
    public $fromUser = auth()->user();
    public $toUser;

    public $message_text;
    public $response;
    public $messageStatus;

    use WithPagination;

    public function mount($toUserId)
    {
        $this->messageStatus = MessageStatus::where('code', '=', MessageStatus::SEEN)->first();
        $this->toUser = User::find($toUserId);
    }

    public function render()
    {
        $messages = Message::where('from_user_id', '=', $this->fromUser->id)
                        ->where('to_user_id', '=', $this->toUser->id);

        $messages->update([
            'status'=> $this->messageStatus->id
        ]);

        return view('livewire.chat', [
            'messages' => $messages->latest()->paginate(1),
        ]);
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
