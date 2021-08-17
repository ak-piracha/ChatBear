<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class message_statuses extends Model
{
    protected $dates = [ 'created_at', 'updated_at'];
    protected $fillable = [
        'type'
        ];
}
