<?php
namespace App\Repositories;


use App\Models\Permission;
use Carbon\Carbon;

class HelpRepository{

    /**
     * @name        getMenu
     * @param       none
     * @return      Array
     * @version     1.0
     * @author      < 18681032630@163.com >
     */
    public static function getMenu(){
        $permissions = Permission::where('status',0)->where('type',0)->get();
        $parentPermission = [];
        $childPermission = [];
        foreach ($permissions as $permission) {
            if(!$permission->pid)
            {
                array_push($parentPermission,$permission->toArray());
            }else{
                array_push($childPermission,$permission->toArray());
            }
        }
        foreach ($childPermission as $permission) {
            foreach ($parentPermission as $key => $parent) {
                if($permission['pid'] == $parent['id'])
                {
                    $parentPermission[$key]['children'][] = $permission;
                }
            }
        }
        return $parentPermission;
    }

    /**
     * @name        getVarName
     * @DateTime    ${DATE}
     * @param       int
     * @return      string
     * @version     1.0
     * @author      < 18681032630@163.com >
     */
    public static function getVarName($type = 1)
    {
        $head   = ['Web_',"Admin_"];
        $chars  = $head[$type].self::getChars(6).'_'. ( Carbon::now()->timestamp - 1493000000);
        return $chars;

    }

    /**
     * @name        getChars
     * @DateTime    ${DATE}
     * @param       int
     * @return      string
     * @version     1.0
     * @author      < 18681032630@163.com >
     */
    public static function getChars($len = 4)
    {
        $chars = ['A','B','C','D','E','F','G','H','I','J','K','L','M','N','O',
            'P','Q','R','S','T','U','V','W','X','Y','Z'];
        $string = '';
        for($i = 0; $i < $len; $i++)
        {
            $string .= $chars[ mt_rand(0, COUNT($chars) - 1) ];
        }
        return $string;
    }


}