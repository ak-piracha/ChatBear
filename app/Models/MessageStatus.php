<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class MessageStatus extends Model
{

    const SEEN = 'seen';
    const UNSEEN = 'unseen';


    protected $fillable = [
        'name',
        'code',
    ];

    protected $dates = [
        'created_at',
        'updated_at',
    ];


    public static function getAllMessageStatuses()
    {
        return [
            self::SEEN,
            self::UNSEEN,
        ];
    }

}
