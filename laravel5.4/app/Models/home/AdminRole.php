<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class AdminRole extends Model
{
    protected $table = 'admin_role';  //表名
    public $timestamps = false;  //过滤默认的字段
}
