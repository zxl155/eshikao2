<?php

namespace App\Admin\Models;

use Illuminate\Database\Eloquent\Model;
use DB;

class Pplive extends Model
{
    protected $table = 'pplive';  //表名
    public $timestamps = false;  //过滤默认的字段


	/**
     * @李一明
     * @DateTime  2018-06-15
     * 添加入库
     */
	public function insert($data){
		$res = DB::table('pplive')->insert(['curriculum_id'=>$data['curriculum_id'],'pplive_name'=>$data['pplive_name'],'start_time'=>$data['start_time'],'end_time'=>$data['end_time'],'admin_id'=>$data['admin_id'],'assistant_admin_id'=>$data['assistant_admin_id']]);
        if($res){
        	return true;
        }else {
        	return false;
        }
	}

	/**
     * @李一明
     * @DateTime  2018-06-15
     * 查询所属课程
     */
	public function select($curriculum_id){
		$arr = DB::table('pplive')->where('curriculum_id',$curriculum_id)->get()->toarray();
		$data = DB::table('admin')->get()->toarray();
		foreach ($arr as $key => $value) {
			foreach ($data as $keys => $values) {
				if ($value->admin_id == $values->admin_id) {
					$value->admin_name = $values->admin_name;
				}
			}
		}
		foreach ($arr as $key => $value) {
			foreach ($data as $keys => $values) {
				if ($value->assistant_admin_id == $values->admin_id) {
					$value->assistant_admin_name = $values->admin_name;
				}
			}
		}
		return $arr;
	}
	//删除直播课程
	public function deletes($pplive_id)
	{
		$arr = DB::table('pplive')->where('pplive_id', '=', $pplive_id)->delete();
		return $arr;
	}
	//查询单条直播课程
	public function oneSelect($pplive_id)
	{
		$arr = DB::table('pplive')->where('pplive_id',$pplive_id)->get()->toarray();
		return $arr;
	}
	//修改
	public function updspplive($data)
	{
		$res = DB::table('pplive')->where('pplive_id','=',$data['pplive_id'])->update(['pplive_name'=>$data['pplive_name'],'start_time'=>$data['start_time'],'end_time'=>$data['end_time'],'admin_id'=>$data['admin_id'],'assistant_admin_id'=>$data['assistant_admin_id']]);
		return $res;
	}
	//查询admin_id 对应的直播
	public function admin_pplive($admin_id)
	{
		//$users = DB::table('pplive')->whereBetween(DA, array(1, 100))->get();
		$pplive = DB::table('pplive')->orderBy('start_time', 'asc')->where('admin_id',$admin_id)->get()->toarray();
		$pplives = DB::table('pplive')->where('assistant_admin_id',$admin_id)->get()->toarray();
		$pplive = array_merge($pplives,$pplive);
		//print_r($pplive);die;
		$curriculum = DB::table('curriculum')->get()->toarray();
		$admin = DB::table('admin')->get()->toarray();
		foreach ($pplive as $key => $val) {
			foreach ($admin as $keys => $value) {
				if($val->admin_id == $value->admin_id){
					$val->admin_name = $value->admin_name;
				}
				if($val->assistant_admin_id == $value->admin_id){
					$val->assistant_admin_name = $value->admin_name;
				} 
				$val->admins_id = $admin_id;
				$val->date_time = date('Y-m-d H:i:s');
			}
		}
		foreach ($pplive as $key => $val) {
			foreach ($curriculum as $keys => $value) {
				if ($val->curriculum_id==$value->curriculum_id) {
					$val->curriculum_name = $value->curriculum_name;
				}
			}
		}
		return $pplive;
	}
}
