<?php

namespace App\Admin\Models;

use Illuminate\Database\Eloquent\Model;

class CatType extends Model
{
    protected $table = 'cat_type';  //表名
    public $timestamps = false;  //过滤默认的字段
}
