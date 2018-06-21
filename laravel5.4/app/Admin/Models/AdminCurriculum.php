<?php

namespace App\Admin\Models;

use Illuminate\Database\Eloquent\Model;

class AdminCurriculum extends Model
{
    protected $table = 'admin_curriculum';  //表名
    public $timestamps = false;  //过滤默认的字段
}
