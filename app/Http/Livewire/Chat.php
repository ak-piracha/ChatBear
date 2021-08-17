<?php

namespace App\Http\Livewire;

use Carbon\Carbon;
use App\Models\Room;
use App\Models\Message;
use Livewire\Component;
use Illuminate\Foundation\Auth\User;
use Illuminate\Support\Facades\Auth;

use function PHPUnit\Framework\isNull;

class Chat extends Component
{
    public $first_user;
    public $second_user;
    public $chat_room;
    public $message_text;
    public $room;
    public $response;

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
        ->get()
        ->sortBy(callback: 'id');
        
        return view('livewire.chat' , compact(var_name:'messages'));
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
