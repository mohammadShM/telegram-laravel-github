<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * @property mixed blocked_users
 * @property mixed share_phone_number_exceptions
 */
class Security extends Model
{
    use SoftDeletes;
    protected $table = 'security';


    //region security access level constants ===========================================================================
    const ACCESS_LEVEL_EVERYONE = 'everyone';
    const ACCESS_LEVEL_CONTACTS = 'contacts';
    const ACCESS_LEVEL_NOBODY = 'nobody';
    const ACCESS_LEVELS = [self::ACCESS_LEVEL_EVERYONE, self::ACCESS_LEVEL_CONTACTS, self::ACCESS_LEVEL_NOBODY];
    //endregion security access level constants ************************************************************************


    //region props =====================================================================================================
    protected $fillable = [
        'blocked_users',
        'share_phone_number',
        'share_phone_number_exceptions',
        'last_seen',
        'last_seen_exceptions',
        'forward_message',
        'forward_message_exceptions',
        'profile_photo',
        'profile_photo_exceptions',
        'add_to_groups',
        'add_to_groups_exceptions',
    ];
    protected $casts = [
        'blocked_users' => 'array',
        'share_phone_number_exceptions' => 'array',
        'last_seen_exceptions' => 'array',
        'forward_message_exceptions' => 'array',
        'profile_photo_exceptions' => 'array',
        'add_to_groups_exceptions' => 'array',
    ];
    //region props *****************************************************************************************************


    //region relations =================================================================================================
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function blockUsers()
    {
        /** @noinspection PhpUndefinedMethodInspection */
        return User::whereIn('id',$this->blocked_users)->get();
    }

    public function SharePhoneNumberExceptionUsers()
    {
        /** @noinspection PhpUndefinedMethodInspection */
        return User::whereIn('id',$this->share_phone_number_exceptions)->get();
    }
    //endregion relation ***********************************************************************************************

}
