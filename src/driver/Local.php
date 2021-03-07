<?php

namespace ffhome\upload\driver;

use ffhome\upload\FileBase;
use ffhome\upload\trigger\SaveDb;
use think\facade\Db;

/**
 * 本地上传
 * Class Local
 * @package EasyAdmin\upload\driver
 */
class Local extends FileBase
{
    /**
     * 重写上传方法
     * @return array|void
     */
    public function save()
    {
        $md5 = $this->file->md5();
        $row = Db::name($this->tableName)->where('md5', $md5)->find();
        if (!empty($row)) {
            return [
                'save' => true,
                'msg' => '上传成功',
                'url' => $row['url'],
            ];
        }
        parent::save();
        SaveDb::trigger($this->tableName, [
            'upload_type' => $this->uploadType,
            'original_name' => $this->file->getOriginalName(),
            'mime_type' => $this->file->getOriginalMime(),
            'file_ext' => strtolower($this->file->getOriginalExtension()),
            'url' => $this->completeFileUrl,
            'md5' => $md5,
            'create_by' => $this->createBy,
            'create_time' => date('Y-m-d H:i:s'),
        ]);
        return [
            'save' => true,
            'msg' => '上传成功',
            'url' => $this->completeFileUrl,
        ];
    }
}