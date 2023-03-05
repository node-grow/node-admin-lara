<?php

namespace NodeAdmin\Models;

use DateTimeInterface;
use Illuminate\Database\Eloquent\Model;
use NodeAdmin\Lib\Constants;

class AdminMenu extends Model
{
    protected $table='admin_menu';

    protected $fillable = [
        'title',
        'url',
        'name',
        'pid',
    ];

    protected $casts=[
        'updated_at'=>'datetime'
    ];

    protected function serializeDate(DateTimeInterface $date)
    {
        return $date->format('Y-m-d H:i:s');
    }

    protected $appends = ['status_text'];

    public function getStatusTextAttribute(){
        return Constants::getCommonStatus($this->status);
    }
}
