<?php

namespace App\Admin\Models;

use Illuminate\Database\Eloquent\Model;
use DB;

class Recruitment extends Model
{
    protected $table = 'recruitment';  //表名
    public $timestamps = false;  //过滤默认的字段

    /**
     * @李一明
     * @DateTime  2018-06-19
     * 公告添加
     */
    public function insert($data){
    	$arr = DB::insert('insert into recruitment (recruitment_name,add_time,region_id,content,recruitment_file) values (?, ?, ? ,?,?)',
        [$data['recruitment_name'],$data['add_time'],$data['region_id'],$data['content'],$data['recruitment_file']]);
        if($arr){
        	return true;
        }else {
        	return false;
        }
    }

    /**
     * @李一明
     * @DateTime  2018-06-19
     * 公告修改
     */
    public function upd($data){
        $arr = DB::table('recruitment')->where('recruitment_id','=',$data['recruitment_id'])->update(['recruitment_name'=>$data['recruitment_name'],'content'=>$data['content'],'recruitment_file'=>$data['recruitment_file'],'region_id'=>$data['region_id']]);
        if($arr){
            return true;
        }else{
            return false;
        }
    }

    public function selects($recruitment_id)
    {   
        $res = DB::table('recruitment')->where('recruitment_id',$recruitment_id)->get()->toarray();
        return $res;
    }
}