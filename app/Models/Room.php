<?php

namespace App\Models;

use Illuminate\Support\Facades\Auth;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

use function PHPUnit\Framework\isEmpty;
use function PHPUnit\Framework\isNull;

class Room extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'user_a_id',
        'user_b_id',
        'type_id',
    ];
    public function user()
    {
        return $this->hasMany(User::class);
    }

    public function roomType()
    {
        return $this->belongsTo(RoomType::class);
    }

    public function roomsList()
    {   
         $rooms_list = Room::where('user_b_id', '=', Auth::user()->id)
            ->orWhere('user_a_id', '=', Auth::user()->id)
            ->get();
        
            return $rooms_list;
    }

    public function chatRoom()
    {   
         $chat_room = Room::where('user_b_id', '=', Auth::user()->id)
            ->orWhere('user_a_id', '=', Auth::user()->id)
            ->first();
        
            return $chat_room;
    }

    public function chatWith(User $user)
    {   
        $chat_with = $this->chatRoom();

         $conversation_with = $chat_with->user_a_id == $user->id ? $chat_with->user_b_id : $chat_with->user_a_id ;
         $conversation_with = User::find($conversation_with);
            return $conversation_with;
    }
    
}
