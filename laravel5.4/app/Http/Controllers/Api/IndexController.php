<?php
namespace App\Http\Controllers\Api;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Input;
use App\Home\Models\User;

class IndexController extends Controller
{
	public function index()
	{
		$record = Input::all();
		if (empty($record['partner_id']) || empty($record['user_tel']) || empty($record['sign'])) {
			$this->var_json('数据不能为空', 0);
		}
		$arg = array(
			'partner_id' => $record['partner_id'],
		    'user_tel'  => $record['user_tel'],
		);
		$signs = $this->interface($arg);
		if($record['partner_id'] != 'eshikao') {
			$this->var_json('partner_id错误', 0);
		} else if ($record['sign'] == $signs) {
			$user = new User;
			$data = $user -> app($record['user_tel']);
			empty($data) ? $this->var_json('无当前用户', 0) : $this->var_json('OK',10001,$data = $data[0]);
		} else {
			$this->var_json('sign错误', 0);
		}
	}
	//拼接参数
	public function interface($arg)
	{
		$query_string = http_build_query($arg);
		$partner_key = "C0fV8gWo7lbFTyqDZM8AwYwbqbc0QqAM/uCwlJp/Ohip0Iz8bWp4VeLKvj4hM5hx3czelHEN5TEl2LeIxIFFaA==";
		$signs = md5($query_string.'&partner_key='.$partner_key);
		return $signs;
	}
	//接口返回值
	public function var_json($info = '', $code = 10000, $data = array()) 
	{
	    $out['code'] = $code ?: 0;
	    $out['info'] = $info ?: ($out['code'] ? 'error' : 'success');
	    $out['data'] = $data ?: array();
	    header('Content-Type: application/json; charset=utf-8');
	    echo json_encode($out);
	    exit(0);
	}
}