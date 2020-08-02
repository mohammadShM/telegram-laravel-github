<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class ChatOptions extends Model
{

    use SoftDeletes;
    protected $table = 'chat_options';


    //region props =====================================================================================================
    protected $fillable = ['chat_id', 'name', 'description', 'photos', 'scope',
        'link', 'sign_messages', 'show_chat_history',];
    protected $hidden = ['deleted_at', 'updated_at'];
    protected $casts = ['photos' => 'array'];
    //region props *****************************************************************************************************


    //region chat scope ================================================================================================
    const CHAT_SCOPE_PRIVATE = 'private';
    const CHAT_SCOPE_PUBLIC = 'public';
    const CHAT_SCOPES = [self::CHAT_SCOPE_PRIVATE, self::CHAT_SCOPE_PUBLIC];
    //endregion chat scope *********************************************************************************************

    //region relations =================================================================================================
    public function creator()
    {
        return $this->belongsTo(Chat::class);
    }
    //endregion relations **********************************************************************************************


    //region static methods ============================================================================================
    public static function permissionGenerator(
        bool $addParticipant = null,
        bool $sendMessage = null,
        bool $sendMedia = null,
        bool $pinMessage = null,
        int $messageCount = null
    )
    {
        if (is_null($addParticipant)) $addParticipant =
            env('CHAT_PERMISSION_DEFAULT_ADD_PARTICIPANT', false);
        if (is_null($sendMessage)) $sendMessage =
            env('CHAT_PERMISSION_DEFAULT_SEND_MESSAGE', true);
        if (is_null($sendMedia)) $sendMedia =
            env('CHAT_PERMISSION_DEFAULT_SEND_MEDIA', true);
        if (is_null($pinMessage)) $pinMessage =
            env('CHAT_PERMISSION_DEFAULT_PIN_MESSAGE', false);
        if (is_null($messageCount)) $messageCount =
            env('CHAT_PERMISSION_DEFAULT_LIMIT_MESSAGE_COUNT', 100);
        return compact('addParticipant', 'sendMessage', 'sendMedia', 'pinMessage', 'messageCount');
    }
    //endregion static methods *****************************************************************************************


}
