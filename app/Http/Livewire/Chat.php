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
        if(!(is_null($this->message_text))){      
        Message::create([
            'room_id' => $this->chat_room->id,
            'user_id' => $this->first_user->id,
            'message' => $this->message_text,
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now(),
        ]);

        $this->response = $this->sendNotification($this->second_user->name, $this->message_text);
    
        
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

    function sendNotification($user, $msg){
    
        $send_from = array(
            "en" => 'Chat Bear  :  ' . $user
            );
          
        $message = array(
            "en" => 'Message  :  ' . $msg
            );    
        
        $fields = array(
            'app_id' => "5a50b1f0-8f3c-4a23-8845-569719f996c6",
            'include_player_ids' => array("4fc1ced3-2c79-45d8-b479-6aedd81a4ead","263ab464-39e1-4972-ad96-e02ba3e886d9"),
            
            'headings' => $send_from,
            'contents' => $message,
            
            'url'      => 'http://chatbear.test/chatroom/'
        );
        
        $fields = json_encode($fields);
        
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, "https://onesignal.com/api/v1/notifications");
        curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type: application/json; charset=utf-8',
                                                    'Authorization: Basic YTM3Y2QxZjAtMjczYS00MWQ1LTk1MTAtMjEwOTBmMjQ4Nzc2'));
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, TRUE);
        curl_setopt($ch, CURLOPT_HEADER, FALSE);
        curl_setopt($ch, CURLOPT_POST, TRUE);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $fields);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, FALSE);

        $response = curl_exec($ch);
        curl_close($ch);
        
        return $response;
    }

}
