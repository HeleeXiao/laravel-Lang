<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class File extends Model
{
    /**
     * @var string
     */
    protected $table = "files";

    /**
     * @var array
     */
    protected $fillable = [ 'lang_id','links','status'];

}
