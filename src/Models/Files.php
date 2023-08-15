<?php

namespace NodeAdmin\Models;

use Illuminate\Database\Eloquent\Model;
use NodeAdmin\Exceptions\NodeException;
use NodeAdmin\Lib\DiskHandlers\BaseDiskHandler;

class Files extends Model
{
    protected $hidden = [
        'created_at',
        'updated_at',
        'status',
        'type',
        'filename',
        'ext',
        'disk',
        'path',
    ];

    protected $fillable = [
        'filename',
        'url',
        'size',
        'type',
        'ext',
        'path',
        'disk',
    ];

    /** @var BaseDiskHandler[] $disk_handlers */
    protected static $disk_handlers = [];

    /**
     * 增加disk_handler
     * @param BaseDiskHandler $handler
     */
    public static function addDiskHandler(BaseDiskHandler $handler)
    {
        self::$disk_handlers[$handler->getDiskName()] = $handler;
    }

    public function getUrl($options = null)
    {
        if (!$options && $this->url) {
            return $this->url;
        }
        if (!isset(self::$disk_handlers[$this->disk])) {
            throw new NodeException("This file disk '{$this->disk}' has no valid handler, please set a handler by 'Files::addDiskHandler(\$handler)' first");
        }
        return self::$disk_handlers[$this->disk]->getFileUrl($this->path, $options);
    }

    public function toArray()
    {
        $res = parent::toArray();
        $res['name'] = $this->filename;
        $res['url'] = $this->getUrl();
        return $res;
    }
}
