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
    public function getRoomId()
    {
        $id = Auth::user()->id == 3 ? 2 : 1;

        return Room::where( 'id' , '=' ,$id )->first();
    }

    public function getRoomWith()
    {   
         $roomWith = Room::where('user_b_id', '=', Auth::user()->id)
            ->orWhere('user_a_id', '=', Auth::user()->id)
            ->get();
        
            return $roomWith;
    }

    public function getConversationWith()
    {   
         $roomWith = Room::where('user_b_id', '=', Auth::user()->id)
            ->orWhere('user_a_id', '=', Auth::user()->id)
            ->first();
        
            return $roomWith;
    }
    public function conversationRoom(User $user)
    {   
        $roomWith = $this->getConversationWith();

         $conversationWith = $roomWith->user_a_id == $user->id ? $roomWith->user_b_id : $roomWith->user_a_id ;
         $conversationWith = User::find($conversationWith);
            return $conversationWith;
    }
    
}
