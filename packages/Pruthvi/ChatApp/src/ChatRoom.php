<?php

namespace Pruthvi\ChatApp;

use Illuminate\Database\Eloquent\Model;

class ChatRoom extends Model
{
    protected $table = 'chat_rooms';

    protected $fillable = ['name'];

    public function messages()
    {
        return $this->hasMany('Message', 'chat_room_id');
    }
}
