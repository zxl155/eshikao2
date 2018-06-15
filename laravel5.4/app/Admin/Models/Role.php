<?php

namespace App\Admin\Models;

use Illuminate\Database\Eloquent\Model;

class Role extends Model
{
    protected $table = 'role';  //表名
    public $timestamps = false;  //过滤默认的字段
}
