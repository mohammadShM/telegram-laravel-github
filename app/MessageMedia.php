<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class MessageMedia extends Model
{
    use SoftDeletes;
    protected $table = 'message_media';


    //region status ====================================================================================================
    const MEDIA_TYPE_FILE = 'file';
    const MEDIA_TYPE_IMAGE = 'image';
    const MEDIA_TYPE_AUDIO = 'audio';
    const MEDIA_TYPE_VIDEO = 'video';
    const MEDIA_TYPES = [self::MEDIA_TYPE_FILE, self::MEDIA_TYPE_IMAGE,
        self::MEDIA_TYPE_AUDIO, self::MEDIA_TYPE_VIDEO];
    //region status ****************************************************************************************************


    //region props =====================================================================================================
    protected $fillable = ['message_id', 'type', 'mime_type', 'size', 'thumbnail',];
    //region props *****************************************************************************************************


    //region relations =================================================================================================
    public function message()
    {
        return $this->belongsTo(Message::class);
    }
    //endregion relations **********************************************************************************************


}
