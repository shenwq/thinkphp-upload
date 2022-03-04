<?php

namespace ffhome\upload;

use ffhome\upload\driver\Local;
use think\File;

/**
 * 上传组件
 * Class Uploadfile
 * @package EasyAdmin\upload
 */
class Uploadfile
{

    /**
     * 当前实例对象
     * @var object
     */
    protected static $instance;

    /**
     * 上传方式
     * @var string
     */
    protected $uploadType = 'local';

    /**
     * 上传配置文件
     * @var array
     */
    protected $uploadConfig;

    /**
     * 需要上传的文件对象
     * @var File
     */
    protected $file;

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
     * 创建人
     * @var string
     */
    protected $createBy;

    /**
     * 保存上传文件的数据表
     * @var string
     */
    protected $tableName = 'system_uploadfile';

    /**
     * 获取对象实例
     * @return Uploadfile|object
     */
    public static function instance()
    {
        if (is_null(self::$instance)) {
            self::$instance = new static();
        }
        return self::$instance;
    }

    /**
     * 设置上传对象
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
     * 设置创建人
     * @param string $createBy
     */
    public function setCreateBy($createBy)
    {
        $this->createBy = $createBy;
        return $this;
    }

    /**
     * 设置上传文件
     * @param $value
     * @return $this
     */
    public function setUploadConfig($value)
    {
        $this->uploadConfig = $value;
        return $this;
    }

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
     * 设置保存数据表
     * @param $value
     * @return $this
     */
    public function setTableName($value)
    {
        $this->tableName = $value;
        return $this;
    }

    /**
     * 保存文件
     * @return array|void
     */
    public function save()
    {
        $obj = null;
        if ($this->uploadType == 'local') {
            $obj = new Local();
        }
        $save = $obj->setUploadConfig($this->uploadConfig)
            ->setUploadType($this->uploadType)
            ->setTableName($this->tableName)
            ->setFile($this->file)
            ->setWidth($this->width)
            ->setHeight($this->height)
            ->setCreateBy($this->createBy)
            ->save();
        return $save;
    }
}