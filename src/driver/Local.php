<?php

namespace ffhome\upload\driver;

use ffhome\common\util\Thumb;
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
        $url = $this->completeFileUrl;
        if ($this->uploadType == 'local') {
            $url = parse_url($url)['path'];
        }
        if ($this->compress) {
            $url = Thumb::size($url, $this->width, $this->height, true);
        }
        SaveDb::trigger($this->tableName, [
            'upload_type' => $this->uploadType,
            'original_name' => $this->file->getOriginalName(),
            'mime_type' => $this->file->getOriginalMime(),
            'file_ext' => strtolower($this->file->getOriginalExtension()),
            'url' => $url,
            'md5' => $md5,
            'create_by' => $this->createBy,
            'create_time' => date('Y-m-d H:i:s'),
        ]);
        return [
            'save' => true,
            'msg' => '上传成功',
            'url' => $url,
        ];
    }
}