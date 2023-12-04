<?php

namespace ffhome\upload\trigger;

use think\facade\Db;

/**
 * 保存到数据库
 * Class SaveDb
 * @package EasyAdmin\upload\trigger
 */
class SaveDb
{

    /**
     * 保存上传文件
     * @param $tableName
     * @param $data
     */
    public static function trigger($tableName, $data)
    {
        if (!isset($data['id'])) {
            return Db::name($tableName)->insertGetId($data);
        }
        Db::name($tableName)->update($data);
        return 0;
    }

}