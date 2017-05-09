<?php

namespace App\Models;

use App\User;
use Illuminate\Database\Eloquent\Model;

class Lang extends Model
{
    /**
     * @var string
     */
    protected $table = "lang";

    /**
     * @var array
     */
    protected $fillable = [ 'file_id','url','title','description','person','status','type'];

    /**
     * @name        files
     * @DateTime    ${DATE}
     * @param       null
     * @return      object
     * @version     1.0
     * @author      < 18681032630@163.com >
     */
    public function files (){
        return $this->hasMany(File::class,'id','file_id');
    }

    /**
     * @name        keywords
     * @DateTime    ${DATE}
     * @param       null
     * @return      object
     * @version     1.0
     * @author      < 18681032630@163.com >
     */
    public function keyWords () {
        return $this->hasMany(Keyword::class,'lang_id','id');
    }

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
