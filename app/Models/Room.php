<?php

namespace App\Models;

use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Auth;
use function PHPUnit\Framework\isNull;
use function PHPUnit\Framework\isEmpty;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

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

    public function addRoom($room_name,$second_user)
    {   
        Room::create([
            'name' => $room_name,
            'user_a_id' => Auth::user()->id,
            'user_b_id' => $second_user->id,
            'type_id' => RoomType::find(1)->id,
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now(),
        ]);
        
    }
}
