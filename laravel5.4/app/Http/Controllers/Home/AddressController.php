<?php

namespace App\Http\Controllers\Home;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Input;
use App\Home\Models\GoodsAddress;
use Redirect;

class AddressController extends Controller
{
	/**
     * @
     * @DateTime  2018-06-12
     * 前台收货地址张晓龙
     */
	public function index()
	{
		$goods = new GoodsAddress;
		$content = $goods->select();
		return view('home/address/userAddress',['content' => $content]);
	}
	/**
     * @
     * @DateTime  2018-06-20
     * 前台添加收货地址张晓龙
     */
	public function addressAdd()
	{
		$data = Input::all();
		$goods = new GoodsAddress;
		$arr = $goods->insert($data);
		$content = $goods->select();
		if ($arr == true) {
			
				$data['content'] = $content;
				$data['data'] = '正确';
			
		} else {
			$data['data'] = '错误';
		}
		return json_encode($data);
	}
	/**
     * @
     * @DateTime  2018-06-20
     * 前台删除收货地址张晓龙
     */
	public function addressDelete()
	{
		$address_id = Input::get('address_id');
		$goods = new GoodsAddress;
		$arr = $goods->deletes($address_id);
		if ($arr) {
			return redirect('home/address.html');
		} else {
			return redirect('home/address.html');
		}
	}
	/**
     * @
     * @DateTime  2018-06-20
     * 前台修改收货地址张晓龙
     */
	public function addressUpdate()
	{
		$address_id = Input::get('address_id');
		$goods = new GoodsAddress;
		$arr = $goods->updates($address_id);
		return view('home/address/userAddresss',['data'=>$arr]);
	}
	public function addressUpdates()
	{
		$data = Input::all();
		$goods = new GoodsAddress;
		$arr = $goods->updatess($data);
		if ($arr) {
			$data['is'] = '正确';
		} else {
			$data['is'] = '错误';
		}
		return json_encode($data);
	}
}