<?php

namespace App\Models;

use App\User;
use Illuminate\Database\Eloquent\Model;

class Keyword extends Model
{
    /**
     * @var string
     */
    protected $table = "keywords";

    /**
     * @var array
     */
    protected $fillable = [
        'lang_id','var_name','chinese','japanese','person',
        'status',"type","description",'order'   ];

    /**
     * @name        personUser
     * @DateTime    ${DATE}
     * @param       null
     * @return      object
     * @version     1.0
     * @author      < 18681032630@163.com >
     */
    public function personUser()
    {
        return $this->hasOne(User::class,'id','person');
    }
    /**
     * @name        sponsorUser
     * @DateTime    ${DATE}
     * @param       null
     * @return      object
     * @version     1.0
     * @author      < 18681032630@163.com >
     */
    public function sponsorUser()
    {
        return $this->hasOne(User::class,'id','sponsor');
    }

}
