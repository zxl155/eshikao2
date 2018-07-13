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
		$start_time =  strtotime($data['start_time']);
		$end_time = strtotime($data['end_time']);
		$params =  [
		    "partner_id" => 70707480, //百家云 合作方id
		    "title" =>$data['pplive_name'], //直播间标题
		    "start_time" => $start_time, //开课时间, unix时间戳（秒）
		    "end_time" => $end_time, //下课时间, unix时间戳（秒） |k
		    "type" => 2, //普通大班课
		    "timestamp" => time(),
		    //"pre_enter_time" => 1800, //学生可提前进入的时间，单位为秒，默认为30分钟
		    "is_long_term" => 0, //普通房间 
		    //"is_group_live" => 0, //是否是分组直播，0:常规直播 
		    "template_name" => "oneone", //oneone(单视频模板)
		    "teacher_need_detect_device" =>1, //老师是否启用设备检测 1:启用
		    "student_need_detect_device" =>1, //学生是否启用设备检测 1:启用
		    "is_video_main"=>1, //指定PC端是否以视频为主 1:以视频为主
		];
		$partner_key = "C0fV8gWo7lbFTyqDZM8AwYwbqbc0QqAM/uCwlJp/Ohip0Iz8bWp4VeLKvj4hM5hx3czelHEN5TEl2LeIxIFFaA==";
		ksort($params);//将参数按key进行排序
	    $str = '';
	    $ginseng= '';
	    foreach ($params as $k => $val) {
	        $str .= "{$k}={$val}&"; //拼接成 key1=value1&key2=value2&...&keyN=valueN& 的形式
	    }

	    $ginseng = $str; //赋值
	    $str .= "partner_key=" . $partner_key; //结尾再拼上 partner_key=$partner_key
	    $sign = md5($str); //计算md5值
	    $ginseng .="sign=" . $sign; 
	     $ch = curl_init();//初始化curl
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false); // 跳过证书检查
       // curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, true);  // 从证书中检查SSL加密算法是否存在
        curl_setopt($ch, CURLOPT_URL,"https://api.baijiayun.com/openapi/room/create");//抓取指定网页
        curl_setopt($ch, CURLOPT_HEADER, 0);//设置header
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);//要求结果为字符串且输出到屏幕上
        curl_setopt($ch, CURLOPT_POST, 1);//post提交方式
        curl_setopt($ch, CURLOPT_POSTFIELDS, $ginseng);
        $arr = curl_exec($ch);//运行curl
        $arr = json_decode($arr);
        if($arr->code == 0) {
        	$res = DB::table('pplive')->insert(['curriculum_id'=>$data['curriculum_id'],'pplive_name'=>$data['pplive_name'],'start_time'=>$data['start_time'],'end_time'=>$data['end_time'],'admin_id'=>$data['admin_id'],'assistant_admin_id'=>$data['assistant_admin_id'],'entrance'=>$arr->data->room_id ]);
	        if($res){
	        	return true;
	        }else {
	        	return false;
	        }

        } else {
        	echo "直播间添加错误";die;
        }

		
	}
	//助教入口
	public function Assistant($pplive_id)
	{
		$pplive = DB::table('pplive')->where('pplive_id',$pplive_id)->get();

		$admin = DB::table('admin')->get();
		//print_r($admin);die;
		foreach ($pplive as $key => $value) {
			foreach ($admin as $k => $val) {
				if($value->assistant_admin_id == $val->admin_id){
					$value->assistant_admin_name = $val->admin_name;
					$value->admin_head = $val->admin_head;
				}
			}
		}
		$params =  [
		    "room_id" => $pplive[0]->entrance, //房间号码
		   	"user_number" => session('data')['admin_id'], //admin——id
		   	"user_name" =>session('data')['nickname'],
		   	"user_role" =>2,
		   	"user_avatar" =>"www.eshikao.com/home/img/admin_head/".$pplive[0]->admin_head."",
		];
		$partner_key = "C0fV8gWo7lbFTyqDZM8AwYwbqbc0QqAM/uCwlJp/Ohip0Iz8bWp4VeLKvj4hM5hx3czelHEN5TEl2LeIxIFFaA==";
		ksort($params);//将参数按key进行排序
	    $str = '';
	    $ginseng= '';
	    foreach ($params as $k => $val) {
	        $str .= "{$k}={$val}&"; //拼接成 key1=value1&key2=value2&...&keyN=valueN& 的形式
	    }
	    $ginseng = $str; //赋值
	    $str .= "partner_key=" . $partner_key; //结尾再拼上 partner_key=$partner_key
	    $sign = md5($str); //计算md5值
	    $ginseng .="sign=" . $sign; 
	    $url = "http://www.baijiayun.com/web/room/enter?".$ginseng;
	    header("Location: ".$url.""); 
	}
	public function teacherShow($pplive_id)
	{
		$pplive = DB::table('pplive')->where('pplive_id',$pplive_id)->get();
		$admin = DB::table('admin')->get();
		//print_r($admin);die;
		foreach ($pplive as $key => $value) {
			foreach ($admin as $k => $val) {
				if($value->admin_id == $val->admin_id){
					$value->admin_name = $val->admin_name;
					$value->admin_head = $val->admin_head;

				}
			}
		}
		$params =  [
		    "room_id" => $pplive[0]->entrance, //房间号码
		   	"user_number" => session('data')['admin_id'], //admin——id
		   	"user_name" =>session('data')['nickname'],
		   	"user_role" =>1,
		   	"user_avatar" => "www.eshikao.com/home/img/admin_head/".$pplive[0]->admin_head."",
		];
		$partner_key = "C0fV8gWo7lbFTyqDZM8AwYwbqbc0QqAM/uCwlJp/Ohip0Iz8bWp4VeLKvj4hM5hx3czelHEN5TEl2LeIxIFFaA==";
		ksort($params);//将参数按key进行排序
	    $str = '';
	    $ginseng= '';
	    foreach ($params as $k => $val) {
	        $str .= "{$k}={$val}&"; //拼接成 key1=value1&key2=value2&...&keyN=valueN& 的形式
	    }
	    $ginseng = $str; //赋值
	    $str .= "partner_key=" . $partner_key; //结尾再拼上 partner_key=$partner_key
	    $sign = md5($str); //计算md5值
	    $ginseng .="sign=" . $sign; 
	    $url = "http://www.baijiayun.com/web/room/enter?".$ginseng;
	    header("Location: ".$url.""); 
	}
	//直播回放
	public function playback($pplive_id)
	{
		$pplive = DB::table('pplive')->where('pplive_id',$pplive_id)->get();
		$params =  [
			"partner_id" => 70707480, //百家云 合作方id
		    "room_id" => $pplive[0]->entrance, //房间号码
		    "timestamp" => time(),
		    "expires_in" => 0,    //回放过期时间

		];
		$partner_key = "C0fV8gWo7lbFTyqDZM8AwYwbqbc0QqAM/uCwlJp/Ohip0Iz8bWp4VeLKvj4hM5hx3czelHEN5TEl2LeIxIFFaA==";
		ksort($params);//将参数按key进行排序
	    $str = '';
	    $ginseng= '';
	    foreach ($params as $k => $val) {
	        $str .= "{$k}={$val}&"; //拼接成 key1=value1&key2=value2&...&keyN=valueN& 的形式
	    }
	    $ginseng = $str; //赋值
	    $str .= "partner_key=" . $partner_key; //结尾再拼上 partner_key=$partner_key
	    $sign = md5($str); //计算md5值
	    $ginseng .="sign=" . $sign; 
	   $ch = curl_init();//初始化curl
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false); // 跳过证书检查
       // curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, true);  // 从证书中检查SSL加密算法是否存在
        curl_setopt($ch, CURLOPT_URL,"https://api.baijiayun.com/openapi/playback/getPlayerToken");//抓取指定网页
        curl_setopt($ch, CURLOPT_HEADER, 0);//设置header
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);//要求结果为字符串且输出到屏幕上
        curl_setopt($ch, CURLOPT_POST, 1);//post提交方式
        curl_setopt($ch, CURLOPT_POSTFIELDS, $ginseng);
        $arr = curl_exec($ch);//运行curl
        $arr = json_decode($arr);
        if ($arr->code == 0) {
        	$url = "http://www.baijiayun.com/web/playback/index?classid=".$pplive[0]->entrance."&token=".$arr->data->token;
        	header("Location: ".$url.""); 
        } else {
        	echo "查询回放token失败";
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
					$value->date_time = date('Y-m-d H:i:s');
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
		$pplive =  DB::table('pplive')->where('pplive_id',$pplive_id)->get();
		$entrance = $pplive[0]->entrance;
		$params =  [
		    "partner_id" => 70707480, //百家云 合作方id
		    "room_id" => $entrance,
		    "timestamp" => time(),
		];
		$partner_key = "C0fV8gWo7lbFTyqDZM8AwYwbqbc0QqAM/uCwlJp/Ohip0Iz8bWp4VeLKvj4hM5hx3czelHEN5TEl2LeIxIFFaA==";
		ksort($params);//将参数按key进行排序
	    $str = '';
	    $ginseng= '';
	    foreach ($params as $k => $val) {
	        $str .= "{$k}={$val}&"; //拼接成 key1=value1&key2=value2&...&keyN=valueN& 的形式
	    }

	    $ginseng = $str; //赋值
	    $str .= "partner_key=" . $partner_key; //结尾再拼上 partner_key=$partner_key
	    $sign = md5($str); //计算md5值
	    $ginseng .="sign=" . $sign; 
	     $ch = curl_init();//初始化curl
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false); // 跳过证书检查
       // curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, true);  // 从证书中检查SSL加密算法是否存在
        curl_setopt($ch, CURLOPT_URL,"https://api.baijiayun.com/openapi/room/delete");//抓取指定网页
        curl_setopt($ch, CURLOPT_HEADER, 0);//设置header
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);//要求结果为字符串且输出到屏幕上
        curl_setopt($ch, CURLOPT_POST, 1);//post提交方式
        curl_setopt($ch, CURLOPT_POSTFIELDS, $ginseng);
        $arr = curl_exec($ch);//运行curl
        $arr = json_decode($arr);
        if ($arr->code == 0 ) {
        	$arr = DB::table('pplive')->where('pplive_id','=', $pplive_id)->delete();
        	
			return $arr;
        } else {
        	echo "删除课程错误";die;
        }
		
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
		$pplive_id =  DB::table('pplive')->where('pplive_id',$data['pplive_id'])->get();
		$entrance = $pplive_id[0]->entrance;
		$start_time =  strtotime($data['start_time']);
		$end_time = strtotime($data['end_time']);
		$params =  [
		    "partner_id" => 70707480, //百家云 合作方id
		    "room_id" => $entrance,
		    "title" =>$data['pplive_name'], //直播间标题
		    "start_time" => $start_time, //开课时间, unix时间戳（秒）
		    "end_time" => $end_time, //下课时间, unix时间戳（秒） |k
		    "type" => 2, //普通大班课
		    "timestamp" => time(),
		    //"pre_enter_time" => 1800, //学生可提前进入的时间，单位为秒，默认为30分钟
		    "is_long_term" => 0, //普通房间 
		    //"is_group_live" => 0, //是否是分组直播，0:常规直播 
		    "template_name" => "oneone", //oneone(单视频模板)
		    "teacher_need_detect_device" =>1, //老师是否启用设备检测 1:启用
		    "student_need_detect_device" =>1, //学生是否启用设备检测 1:启用
		    "is_video_main"=>1, //指定PC端是否以视频为主 1:以视频为主
		];
		$partner_key = "C0fV8gWo7lbFTyqDZM8AwYwbqbc0QqAM/uCwlJp/Ohip0Iz8bWp4VeLKvj4hM5hx3czelHEN5TEl2LeIxIFFaA==";
		ksort($params);//将参数按key进行排序
	    $str = '';
	    $ginseng= '';
	    foreach ($params as $k => $val) {
	        $str .= "{$k}={$val}&"; //拼接成 key1=value1&key2=value2&...&keyN=valueN& 的形式
	    }

	    $ginseng = $str; //赋值
	    $str .= "partner_key=" . $partner_key; //结尾再拼上 partner_key=$partner_key
	    $sign = md5($str); //计算md5值
	    $ginseng .="sign=" . $sign; 
	     $ch = curl_init();//初始化curl
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false); // 跳过证书检查
       // curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, true);  // 从证书中检查SSL加密算法是否存在
        curl_setopt($ch, CURLOPT_URL,"https://api.baijiayun.com/openapi/room/update");//抓取指定网页
        curl_setopt($ch, CURLOPT_HEADER, 0);//设置header
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);//要求结果为字符串且输出到屏幕上
        curl_setopt($ch, CURLOPT_POST, 1);//post提交方式
        curl_setopt($ch, CURLOPT_POSTFIELDS, $ginseng);
        $arr = curl_exec($ch);//运行curl
        $arr = json_decode($arr);
        if ($arr->code == 0) {
        	$res = DB::table('pplive')->where('pplive_id','=',$data['pplive_id'])->update(['pplive_name'=>$data['pplive_name'],'start_time'=>$data['start_time'],'end_time'=>$data['end_time'],'admin_id'=>$data['admin_id'],'assistant_admin_id'=>$data['assistant_admin_id']]);
			return $res;
        } else {
        	echo "修改课程错误";die;
        }
		
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
