<?php

namespace App\Models;

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
    protected $fillable = [ 'keyword_id','file_id','title','description','person','status'];

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
    public function keywords () {
        return $this->hasMany(Keyword::class,'id','keyword_id';
    }

}
