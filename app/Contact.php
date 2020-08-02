<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * @property mixed user_id
 */
class Contact extends Model
{
    use SoftDeletes;
    protected $table = 'contacts';


    //region props =====================================================================================================
    protected $fillable = [
        'user_id', 'contact_id', 'name', 'mobile',
    ];
    //region props *****************************************************************************************************


    //region relations =================================================================================================
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function contact()
    {
        return $this->belongsTo(User::class);
    }
    //region relations *************************************************************************************************


}
