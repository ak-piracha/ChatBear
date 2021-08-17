<?php

namespace App\Models;

use Illuminate\Support\Facades\DB;
use Illuminate\Database\Eloquent\Model;

class Message extends Model
{
    protected $dates = [ 'created_at', 'updated_at'];
    protected $fillable = [
        'room_id',
        'user_id',
        'message',
        ];

    /**
     * A message belong to a user
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }
    public function room()
    {
        return $this->belongsTo(Room::class);
    }

    public function updateMsgStatus($id)
    {   

        DB::table('messages')
        ->where('room_id', '=', $id)
        ->where('status', '=' , '2')
        ->update(['status' => 1]);
    }
}
