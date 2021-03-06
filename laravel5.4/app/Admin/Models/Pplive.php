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
		$pplive_admin = DB::table('pplive')->where(['admin_id'=>$data['admin_id']])->select('pplive_id','start_time','end_time')->get()->toarray();
		foreach ($pplive_admin as $key => $value) {
			$value->start_time = strtotime($value->start_time);
			$value->end_time = strtotime($value->end_time);
		}
		if (!empty($pplive_admin)) {
			foreach ($pplive_admin as $key => $value) {
				if ($value->start_time > $start_time & $value->start_time < $end_time ) {
					$value->is = 1;
				} else if ($value->end_time > $start_time & $value->end_time < $end_time ) {
					$value->is = 1;
				} else if($start_time > $value->start_time & $start_time < $value->end_time) {
					$value->is = 1;
				} else if($end_time > $value->start_time & $end_time < $value->end_time)
					$value->is = 1;
				else {
					$value->is = 0;
				}
				$arr[] = $value->is;
			}
			if(in_array(1,$arr)){
				echo "老师该时间点已有课程";die;
			}
		}
		if ($data['type']==5) {
			$params =  [
			    "partner_id" => 70707480, //百家云 合作方id
			    "title" =>$data['pplive_name'], //直播间标题
			    "start_time" => $start_time, //开课时间, unix时间戳（秒）
			    "end_time" => $end_time, //下课时间, unix时间戳（秒） |k
			    "timestamp" => time(),
			    //"pre_enter_time" => 1800, //学生可提前进入的时间，单位为秒，默认为30分钟
			    "is_mock_live" => 1,//是否为伪直播
			    "mock_room_id" => $data['playback_room_id'],//直播回放room_id
			    "mock_session_id" => $data['playback_session_id'],//直播回放session_id
			    "is_long_term" => 0, //普通房间 
			    //"is_group_live" => 0, //是否是分组直播，0:常规直播 
			    "template_name" => "oneone", //oneone(单视频模板)
			    "teacher_need_detect_device" =>1, //老师是否启用设备检测 1:启用
			    "student_need_detect_device" =>1, //学生是否启用设备检测 1:启用
			    "is_video_main"=>2, //指定PC端是否以视频为主 1:以视频为主
			];
		} else if($data['type']==6) {
			$params =  [
			    "partner_id" => 70707480, //百家云 合作方id
			    "title" =>$data['pplive_name'], //直播间标题
			    "start_time" => $start_time, //开课时间, unix时间戳（秒）
			    "end_time" => $end_time, //下课时间, unix时间戳（秒） |k
			    "timestamp" => time(),
			    //"pre_enter_time" => 1800, //学生可提前进入的时间，单位为秒，默认为30分钟
			    "is_mock_live" => 1,//是否为伪直播
			    "mock_video_id" => $data['demand_id'], //点播id
			    "is_long_term" => 0, //普通房间 
			    //"is_group_live" => 0, //是否是分组直播，0:常规直播 
			    "template_name" => "oneone", //oneone(单视频模板)
			    "teacher_need_detect_device" =>1, //老师是否启用设备检测 1:启用
			    "student_need_detect_device" =>1, //学生是否启用设备检测 1:启用
			    "is_video_main"=>2, //指定PC端是否以视频为主 1:以视频为主
			];
		} else {
			$params =  [
			    "partner_id" => 70707480, //百家云 合作方id
			    "title" =>$data['pplive_name'], //直播间标题
			    "start_time" => $start_time, //开课时间, unix时间戳（秒）
			    "end_time" => $end_time, //下课时间, unix时间戳（秒） |k
			    "type" => $data['type'], //直播房间类型
			    "timestamp" => time(),
			    //"pre_enter_time" => 1800, //学生可提前进入的时间，单位为秒，默认为30分钟
			    "is_long_term" => 0, //普通房间 
			    //"is_group_live" => 0, //是否是分组直播，0:常规直播 
			    "template_name" => "oneone", //oneone(单视频模板)
			    "teacher_need_detect_device" =>1, //老师是否启用设备检测 1:启用
			    "student_need_detect_device" =>1, //学生是否启用设备检测 1:启用
			    "is_video_main"=>2, //指定PC端是否以视频为主 1:以视频为主
			];
		}
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
        	$res = DB::table('pplive')->insert(['curriculum_id'=>$data['curriculum_id'],'pplive_name'=>$data['pplive_name'],'start_time'=>$data['start_time'],'end_time'=>$data['end_time'],'admin_id'=>$data['admin_id'],'assistant_admin_id'=>$data['assistant_admin_id'],'entrance'=>$arr->data->room_id,'type'=>$data['type'],'playback_room_id'=>$data['playback_room_id'],'playback_session_id'=>$data['playback_session_id'],'demand_id'=>$data['demand_id'],'demand_address'=>$data['demand_address'],'is_free'=>$data['is_free']]);
	        if($res){
	        	return true;
	        }else {
	        	return false;
	        }

        } else {
        	if ($data['type'] ==5 || $data['type'] ==6 ) {
        		echo $arr->msg;die;
        	}
        	echo "直播间添加错误(第三方直播间)";die;
        }

		
	}
	//助教入口
	public function Assistant($pplive_id)
	{
		$pplive = DB::table('pplive')->where('pplive_id',$pplive_id)->get();

		$admin = DB::table('admin')->where('admin_id',session('data')['admin_id'])->get();
		foreach ($pplive as $key => $value){	
					$value->admin_head = $admin[0]->admin_head;
		}
		$user_number =  (10000000+strval(session('data')['admin_id']));
		$params =  [
		    "room_id" => $pplive[0]->entrance, //房间号码
		   	"user_number" => $user_number, //admin——id
		   	"user_name" =>session('data')['nickname'],
		   	"user_role" =>2,
		   	"user_avatar" =>"http://www.eshikao.com/home/img/admin_head/".$pplive[0]->admin_head."",
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
		$user_number = (10000000+strval(session('data')['admin_id']));
		$params =  [
		    "room_id" => $pplive[0]->entrance, //房间号码
		   	"user_number" => $user_number, //admin——id
		   	"user_name" =>session('data')['nickname'],
		   	"user_role" =>1,
		   	"user_avatar" => "http://www.eshikao.com/home/img/admin_head/".$pplive[0]->admin_head."",
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
	    $url = "baijiacloud://urlpath=http://www.baijiayun.com/web/room/enter?".$ginseng."&token=token&ts=ts";
	    header("Location: ".$url.""); 
	}
	//直播回放
	public function playback($pplive_id)
	{
		$pplive = DB::table('pplive')->where('pplive_id',$pplive_id)->get();
		if ($pplive[0]->type == 5) {
			$params =  [
				"partner_id" => 70707480, //百家云 合作方id
			    "room_id" => $pplive[0]->playback_room_id, //房间号码
			    "session_id" => $pplive[0]->playback_session_id, //session_id
			    "timestamp" => time(),
			    "expires_in" => 0,    //回放过期时间

			];
		} else {
			$params =  [
				"partner_id" => 70707480, //百家云 合作方id
			    "room_id" => $pplive[0]->entrance, //房间号码
			    "timestamp" => time(),
			    "expires_in" => 0,    //回放过期时间

			];
		} 
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
        	if ($pplive[0]->type == 5) {
        		$url = "http://www.baijiayun.com/web/playback/index?classid=".$pplive[0]->playback_room_id."&session_id=".$pplive[0]->playback_session_id."&token=".$arr->data->token;
        	} else {
        		$url = "http://www.baijiayun.com/web/playback/index?classid=".$pplive[0]->entrance."&token=".$arr->data->token;
        	}
        	
        	header("Location: ".$url.""); 
        } else {
        	if($pplive[0]->type == 6) {
        		$url = $pplive[0]->demand_address;
        		header("Location: ".$url."");die;
        	} 
        	echo "查询回放token失败(第三方直播间)";
        }
	}
	/**
     * @李一明
     * @DateTime  2018-06-15
     * 查询所属课程
     */
	public function select($curriculum_id){
		$sql = "select * from pplive where find_in_set(".$curriculum_id.",curriculum_id) order by start_time desc";
		$arr = DB::select($sql);
		/*print_r($arr);die;
		$arr = DB::table('pplive')->orderBy('start_time','desc')->where('curriculum_id',$curriculum_id)->get()->toarray();*/
		$data = DB::table('admin')->get()->toarray();
		foreach ($arr as $key => $value) {
			foreach ($data as $keys => $values) {
				if ($value->admin_id == $values->admin_id) {
					$value->admin_name = $values->nickname;
					$value->date_time = date('Y-m-d H:i:s');
					$value->start_date_time = date('Y-m-d H:i:s',strtotime('+30 minute'));
				}
			}
		}
		foreach ($arr as $key => $value) {
			foreach ($data as $keys => $values) {
				if ($value->assistant_admin_id == $values->admin_id) {
					$value->assistant_admin_name = $values->nickname;
				}
			}
		}
		return $arr;
	}
	//删除直播课程
	public function deletes($pplive_id,$curriculum_id)
	{
		$pplive = DB::table('pplive')->where('pplive_id',$pplive_id)->get();
	        $curriculum = $pplive[0]->curriculum_id;
			$curriculum = explode(',',$curriculum);
			$count = count($curriculum);
			if($count!=1){
				foreach ($curriculum as $key => $value) {
					if($value == $curriculum_id){
						unset($curriculum[$key]);
					}
				}
				$curriculum = implode($curriculum,',');
				$arr = DB::table('pplive')->where('pplive_id',$pplive_id)->update(['curriculum_id'=>$curriculum]);
				return $arr;die;
			}
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
        	echo $arr->msg."(第三方直播间)";die;
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
		$pplive_admin = DB::table('pplive')->where(['admin_id'=>$data['admin_id']])->select('pplive_id','start_time','end_time')->get()->toarray();
		foreach ($pplive_admin as $key => $value) {
			if ($value->pplive_id == $data['pplive_id']) {
				unset($pplive_admin[$key]);
			}
			$value->start_time = strtotime($value->start_time);
			$value->end_time = strtotime($value->end_time);
		}
		if (!empty($pplive_admin)) {
			foreach ($pplive_admin as $key => $value) {
				if ($value->start_time > $start_time & $value->start_time < $end_time ) {
					$value->is = 1;
				} else if ($value->end_time > $start_time & $value->end_time < $end_time ) {
					$value->is = 1;
				} else if($start_time > $value->start_time & $start_time < $value->end_time) {
					$value->is = 1;
				} else if($end_time > $value->start_time & $end_time < $value->end_time)
					$value->is = 1;
				else {
					$value->is = 0;
				}
				$arr[] = $value->is;
			}
			if(in_array(1,$arr)){
				echo "老师该时间点已有课程";die;
			}
		}
		if ($data['type'] == 5) {
			$params =  [
			    "partner_id" => 70707480, //百家云 合作方id
			    "room_id" => $entrance,
			    "title" =>$data['pplive_name'], //直播间标题
			    "start_time" => $start_time, //开课时间, unix时间戳（秒）
			    "end_time" => $end_time, //下课时间, unix时间戳（秒） |k
			    "timestamp" => time(),
			    "is_mock_live"=>1, //是否为伪直播
			    "mock_room_id" => $data['playback_room_id'], //伪直播房间号
			    "mock_session_id" => $data['playback_session_id'],//直播回放session_id
			    "template_name" => "oneone", //oneone(单视频模板)
			    "teacher_need_detect_device" =>1, //老师是否启用设备检测 1:启用
			    "student_need_detect_device" =>1, //学生是否启用设备检测 1:启用
			    "is_video_main"=>2, //指定PC端是否以视频为主 1:以视频为主
			];
		} else if($data['type'] == 6){
			$params =  [
			    "partner_id" => 70707480, //百家云 合作方id
			    "room_id" => $entrance,
			    "title" =>$data['pplive_name'], //直播间标题
			    "start_time" => $start_time, //开课时间, unix时间戳（秒）
			    "end_time" => $end_time, //下课时间, unix时间戳（秒） |k
			    "timestamp" => time(),
			    "is_mock_live"=>1,
			   	"mock_video_id" => $data['demand_id'], //点播id
			    "template_name" => "oneone", //oneone(单视频模板)
			    "teacher_need_detect_device" =>1, //老师是否启用设备检测 1:启用
			    "student_need_detect_device" =>1, //学生是否启用设备检测 1:启用
			    "is_video_main"=>2, //指定PC端是否以视频为主 1:以视频为主
			];
		} else {
			$params =  [
			    "partner_id" => 70707480, //百家云 合作方id
			    "room_id" => $entrance,
			    "title" =>$data['pplive_name'], //直播间标题
			    "start_time" => $start_time, //开课时间, unix时间戳（秒）
			    "end_time" => $end_time, //下课时间, unix时间戳（秒） |k
			    "type" => $data['type'], //普通大班课
			    "timestamp" => time(),
			];
		}
		
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
        	if ($data['type'] == 6) {
        		$res = DB::table('pplive')->where('pplive_id','=',$data['pplive_id'])->update(['pplive_name'=>$data['pplive_name'],'start_time'=>$data['start_time'],'end_time'=>$data['end_time'],'admin_id'=>$data['admin_id'],'assistant_admin_id'=>$data['assistant_admin_id'],'type'=>$data['type'],'playback_room_id'=>'','playback_session_id'=>'','demand_id'=>$data['demand_id'],'demand_address'=>$data['demand_address'],'is_free'=>$data['is_free']]);
        	} else if ($data['type'] == 5) {
        		$res = DB::table('pplive')->where('pplive_id','=',$data['pplive_id'])->update(['pplive_name'=>$data['pplive_name'],'start_time'=>$data['start_time'],'end_time'=>$data['end_time'],'admin_id'=>$data['admin_id'],'assistant_admin_id'=>$data['assistant_admin_id'],'type'=>$data['type'],'playback_room_id'=>$data['playback_room_id'],'playback_session_id'=>$data['playback_session_id'],'demand_id'=>'','demand_address'=>'','is_free'=>$data['is_free']]);
        	} else {
        		$res = DB::table('pplive')->where('pplive_id','=',$data['pplive_id'])->update(['pplive_name'=>$data['pplive_name'],'start_time'=>$data['start_time'],'end_time'=>$data['end_time'],'admin_id'=>$data['admin_id'],'assistant_admin_id'=>$data['assistant_admin_id'],'type'=>$data['type'],'playback_room_id'=>'','playback_session_id'=>'','demand_id'=>'','demand_address'=>'','is_free'=>$data['is_free']]);
        	}
        	
			return $res;
        } else {
        	if ($data['type'] ==5 || $data['type'] ==6 ) {
        		echo $arr->msg;die;
        	}
        	echo "修改课程错误(第三方直播间)";die;
        }
		
	}
	//查询admin_id 对应的直播
	public function admin_pplive($admin_id)
	{
		//$users = DB::table('pplive')->whereBetween(DA, array(1, 100))->get();
		$pplive = DB::table('pplive')->orderBy('start_time','desc')->where('admin_id',$admin_id)->get()->toarray();
		$pplives = DB::table('pplive')->where('assistant_admin_id',$admin_id)->get()->toarray();
		$pplive = array_merge($pplives,$pplive);
		//print_r($pplive);die;
		$curriculum = DB::table('curriculum')->get()->toarray();
		$admin = DB::table('admin')->get()->toarray();
		foreach ($pplive as $key => $val) {
			foreach ($admin as $keys => $value) {
				if($val->admin_id == $value->admin_id){
					$val->admin_name = $value->nickname;
				}
				if($val->assistant_admin_id == $value->admin_id){
					$val->assistant_admin_name = $value->nickname;
				} 
				$val->admins_id = $admin_id;
				$val->date_time = date('Y-m-d H:i:s');
				$val->start_date_time = date('Y-m-d H:i:s',strtotime('+30 minute'));
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
	//通过课程id查询直播间
	public function copySearch($curriculum_id,$curriculum_ids)
	{
		$sql = "select * from pplive where find_in_set(".$curriculum_id.",curriculum_id) order by start_time desc";
		$arr = DB::select($sql);
		$sqls = "select * from pplive where find_in_set(".$curriculum_ids.",curriculum_id) order by start_time desc";
		$arrs = DB::select($sqls);
		foreach ($arr as $key => $value) {
			foreach ($arrs as $k => $val) {
				if ($value->pplive_id == $val->pplive_id) {
					$value->is = "已有该课程";
				}
			}
			if (empty($value->is)) {
					$value->is = "";
			}
		}
		return $arr;
	}
	//添加复制直播间进行入库
	public function copyPplives($data)
	{

		foreach ($data['pplive_id'] as $key => $value) {
			$pplive = DB::table('pplive')->where('pplive_id',$value)->get();
			$arr = $pplive[0]->curriculum_id.','.$data['curriculum_ids'];
			$all[$key] = DB::table('pplive')->where('pplive_id',$value)->update(['curriculum_id'=>$arr]);
		}
		if(in_array(0, $all)){
			return false;
		} else {
			return true;
		}

	}

	//添加讲义
	public function handoutadds($data)
	{
		$arr = DB::table('pplive')->where(['pplive_id'=>$data['pplive_id']])->update(['jianyi'=>$data['jianyi']]);
		return $arr;
	}
}
