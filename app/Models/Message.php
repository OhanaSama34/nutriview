<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Message extends Model
{
  use HasFactory;  
    protected $fillable =  ['from_user', 'to_user', 'message', 'is_read'];

public function sender()
{
    return $this->belongsTo(User::class, 'from_user');
}

public function receiver()
{
    return $this->belongsTo(User::class, 'to_user');
}

}
