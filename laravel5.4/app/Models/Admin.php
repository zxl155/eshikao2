<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Admin extends Model
{
    protected $table = 'admin';  //表名
    public $timestamps = false;  //过滤默认的字段
}
