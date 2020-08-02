<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * @method static create(array $array)
 * @method static insert(array $toArray)
 */
class ChatParticipant extends Model
{
    use SoftDeletes;
    protected $table = 'chat_participants';


    //region props =====================================================================================================
    protected $fillable = ['chat_id', 'user_id', 'permissions','admin'];
    protected $casts = [
        'permissions' => 'array'
    ];
    //endregion props **************************************************************************************************


    //region relations =================================================================================================
    public function chat()
    {
        return $this->belongsTo(Chat::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }
    //endregion relations **********************************************************************************************

}
