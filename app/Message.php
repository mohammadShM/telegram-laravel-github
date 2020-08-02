<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Message extends Model
{
    use SoftDeletes;
    protected $table = 'messages';


    //region props =====================================================================================================
    protected $fillable = ['sender_id', 'chat_id', 'reply_message_id',
        'forward_message_id', 'media_id', 'body',];
    //region props *****************************************************************************************************


    //region status ====================================================================================================
    const MESSAGE_STATE_PENDING = 'pending';
    const MESSAGE_STATE_SEND = 'send';
    const MESSAGE_STATE_READ = 'view';
    const MESSAGE_STATES = [self::MESSAGE_STATE_PENDING, self::MESSAGE_STATE_SEND, self::MESSAGE_STATE_READ];
    //region status ****************************************************************************************************


    //region relations =================================================================================================
    public function sender()
    {
        return $this->belongsTo(User::class, 'sender_id', 'id');
    }

    public function chat()
    {
        return $this->belongsTo(Chat::class, 'chat_id', 'id');
    }

    public function repliedMessage()
    {
        return $this->belongsTo(Message::class, 'reply_message_id', 'id');
    }

    public function forwardedMessage()
    {
        return $this->belongsTo(Message::class, 'forward_message_id', 'id');
    }

    public function media()
    {
        return $this->hasOne(MessageMedia::class);
    }
    //endregion relations **********************************************************************************************


}
