<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use DB;

class Pplive extends Model
{
    protected $table = 'pplive';  //表名
    public $timestamps = false;  //过滤默认的字段

    /**
     * @李一明
     * @DateTime  2018-06-15
     * 获取星期方法
     */
    function get_week($date){
	    //强制转换日期格式
	    $date_str=date('Y-m-d',strtotime($date));
	    //封装成数组
	    $arr=explode("-", $date_str);
	    //参数赋值
	    //年
	    $year=$arr[0];
	    //月，输出2位整型，不够2位右对齐
	    $month=sprintf('%02d',$arr[1]);
	    //日，输出2位整型，不够2位右对齐
	    $day=sprintf('%02d',$arr[2]);
	    //时分秒默认赋值为0；
	    $hour = $minute = $second = 0;
	    //转换成时间戳
	    $strap = mktime($hour,$minute,$second,$month,$day,$year);
	    //获取数字型星期几
	    $number_wk=date("w",$strap);
	    //自定义星期数组
	    $weekArr=array("星期日","星期一","星期二","星期三","星期四","星期五","星期六");
	    //获取数字对应的星期
	    return $weekArr[$number_wk];
	}

	/**
     * @李一明
     * @DateTime  2018-06-15
     * 添加入库
     */
	public function insert($data){
		$pplive_id = DB::table('pplive')->insertGetId(['pplive_name'=>$data['pplive_name'],'times'=>$data['start_time'],'curriculum_id'=>$data['curriculum_id']]);
        if($pplive_id){
        	return $pplive_id;
        }else {
        	return false;
        }
	}

	/**
     * @李一明
     * @DateTime  2018-06-15
     * 查询所属课程
     */
	public function show($data){
		$curriculum =  DB::select('select * from curriculum');
		foreach ($data as $key => $value) {
			foreach ($curriculum as $keys => $values) {
				if ($value->curriculum_id == $values->curriculum_id) {
					$value->curriculum_name = $values->curriculum_name;
				}
			}
		}
		return $data;
	}
}
