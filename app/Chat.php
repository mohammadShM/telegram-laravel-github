<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * @method static create(array $array)
 * @method static find($chatId)
 * @method static insert(array $toArray)
 * @property mixed creator_id
 * @property mixed id
 * @property mixed options
 * @property mixed photos
 * @property mixed type
 * @property array permissions
 */
class Chat extends Model
{

    use SoftDeletes;
    protected $table = 'chats';

    //region chat type constants =======================================================================================
    const CHAT_TYPE_PRIVATE = 'private';
    const CHAT_TYPE_GROUP = 'group';
    const CHAT_TYPE_CHANNEL = 'channel';
    const CHAT_TYPES = [self::CHAT_TYPE_PRIVATE, self::CHAT_TYPE_GROUP, self::CHAT_TYPE_CHANNEL];
    //endregion chat type constants ************************************************************************************


    //region props =====================================================================================================
    protected $fillable = ['creator_id', 'type', 'permissions', 'notification'];
    protected $casts = [
        'permissions' => 'array',
        'notification' => 'boolean',
    ];
    protected $with = ['options'];
    //endregion props **************************************************************************************************


    //region relations =================================================================================================
    public function creator()
    {
        return $this->belongsTo(User::class, 'creator_id', 'id');
    }

    public function messages()
    {
        return $this->hasMany(Message::class);
    }

    public function options()
    {
        return $this->hasOne(ChatOptions::class);
    }

    public function participants()
    {
        return $this->hasMany(ChatParticipant::class);
    }
    //endregion relations **********************************************************************************************


    //region is of type ================================================================================================
    public function isOfType(String $type)
    {
        return $this->type == $type;
    }

    public function isPrivate()
    {
        return $this->isOfType(self::CHAT_TYPE_PRIVATE);
    }

    public function isGroup()
    {
        return $this->isOfType(self::CHAT_TYPE_GROUP);
    }

    public function isChannel()
    {
        return $this->isOfType(self::CHAT_TYPE_CHANNEL);
    }
    //endregion is of type *********************************************************************************************

    //region permissions checkers ======================================================================================
    public function getParticipantIfExists(User $user): ?ChatParticipant
    {
        /** @var ChatParticipant $participant */
        $participant = $this->participants()->where('user_id', $user->id)->first();
        return $participant;
    }

    public function isThisUserMyParticipant(User $user): bool
    {
        return $this->participants()->where('user_id', $user->id)->exists();
    }

    public function isThisUserMyAdmin(User $user): bool
    {
        return $this->participants()
            ->where('user_id', $user->id)
            ->where('admin', true)
            ->exists();
    }

    public function isMyCreator(User $user): bool
    {
        return $user->id === $this->creator_id;
    }

    public function participantHasPermissions(User $user, string $permissionName): bool
    {
        $participant = $this->getParticipantIfExists($user);
        if (!empty($participant)) {
            return empty($participant->permissions)
                ? !empty($this->permissions[$permissionName])//Haven't accessed this particular user?
                : !empty($participant->permissions[$permissionName]);//If he has access, he should check his own access
        }
        return false;
    }
    //endregion permissions checkers ***********************************************************************************

}
