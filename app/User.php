<?php
//region q111 =================================================================================================

//endregion q111 ***********************************************************************************************
namespace App;

use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Passport\HasApiTokens;

/**
 * @method static create(array $data)
 * @method static whereIn(string $string, array|null $users)
 * @property mixed name
 * @property mixed mobile
 * @property mixed code
 * @property mixed code_expiration
 * @property mixed id
 * @property mixed contacts
 * @property mixed user_id
 * @property mixed last_seen
 * @property mixed security
 * @property mixed admin
 */
class User extends Authenticatable
{
    use Notifiable, SoftDeletes, HasApiTokens;
    protected $table = 'users';


    //region props =====================================================================================================
    protected $fillable = [
        'username', 'name', 'mobile', 'password', 'bio', 'code',
        ];
    protected $hidden = [
        'password', 'code',
    ];
    protected $casts = [
        'code_expiration' => 'datetime',
        'last_seen' => 'datetime',
    ];
    //region props *****************************************************************************************************


    //region  ==========================================================================================================
    public function chats()
    {
        return $this->hasMany(Chat::class, 'creator_id', 'id');
    }

    public function message()
    {
        return $this->hasMany(Message::class, 'sender_id', 'id');
    }

    public function contacts()
    {
        return $this->hasMany(Contact::class,'user_id','id');
    }

    public function security()
    {
        return $this->hasOne(Security::class);
    }
    //endregion relations **********************************************************************************************


    //endregion lastSeen ===============================================================================================
    public function updateLastSeen()
    {
        $this->last_seen = now();
        $this->save();
        return $this;
    }
    //endregion lastSeen ***********************************************************************************************

}
