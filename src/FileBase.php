<?php

namespace ffhome\upload;

use think\facade\Filesystem;

/**
 * 基类
 * Class Base
 * @package EasyAdmin\upload
 */
class FileBase
{

    /**
     * 上传配置
     * @var array
     */
    protected $uploadConfig;

    /**
     * 上传文件对象
     * @var object
     */
    protected $file;

    /**
     * 上传完成的文件路径
     * @var string
     */
    protected $completeFilePath;

    /**
     * 上传完成的文件的URL
     * @var string
     */
    protected $completeFileUrl;

    /**
     * 压缩图片的宽度
     * @var int
     */
    protected $width = 0;

    /**
     * 压缩图片的高度
     * @var int
     */
    protected $height = 0;

    /**
     * 保存上传文件的数据表
     * @var string
     */
    protected $tableName;

    /**
     * 创建人
     * @var string
     */
    protected $createBy;

    /**
     * 上传类型
     * @var string
     */
    protected $uploadType = 'local';

    /**
     * 设置上传方式
     * @param $value
     * @return $this
     */
    public function setUploadType($value)
    {
        $this->uploadType = $value;
        return $this;
    }

    /**
     * 设置上传配置
     * @param $value
     * @return $this
     */
    public function setUploadConfig($value)
    {
        $this->uploadConfig = $value;
        return $this;
    }

    /**
     * 设置上传配置
     * @param $value
     * @return $this
     */
    public function setFile($value)
    {
        $this->file = $value;
        return $this;
    }

    /**
     * 设置压缩图片的宽度
     * @param $value
     * @return $this
     */
    public function setWidth($value)
    {
        $this->width = $value;
        return $this;
    }

    /**
     * 设置压缩图片的高度
     * @param $value
     * @return $this
     */
    public function setHeight($value)
    {
        $this->height = $value;
        return $this;
    }

    /**
     * 设置保存文件数据表
     * @param $value
     * @return $this
     */
    public function setTableName($value)
    {
        $this->tableName = $value;
        return $this;
    }

    /**
     * 设置创建人
     * @param string $createBy
     */
    public function setCreateBy($createBy)
    {
        $this->createBy = $createBy;
        return $this;
    }

    /**
     * 保存文件
     */
    public function save()
    {
        $this->completeFilePath = Filesystem::disk('public')->putFile('upload', $this->file, function () {
            return date('Ymd') . DIRECTORY_SEPARATOR . uniqid();
        });
        $this->completeFileUrl = request()->domain() . '/' . str_replace(DIRECTORY_SEPARATOR, '/', $this->completeFilePath);
    }

    /**
     * 删除保存在本地的文件
     * @return bool|string
     */
    public function rmLocalSave()
    {
        try {
            $rm = unlink($this->completeFilePath);
        } catch (\Exception $e) {
            return $e->getMessage();
        }
        return $rm;
    }
}