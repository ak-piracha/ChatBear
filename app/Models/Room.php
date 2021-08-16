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
    
    public function secondUser(Room $room)
    {   
        $user = Auth::user();

        $second_user = $room->user_a_id == $user->id ? $room->user_b_id : $room->user_a_id ;
        $second_user = User::find($second_user);
           
        return $second_user;
    }
}
