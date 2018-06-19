<?php

namespace App\Http\Controllers\Home;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Input;
use App\Home\Models\Region;
use App\Home\Models\Recruitment;
class NoticeController extends Controller
{
	/**
     * @
     * @DateTime  2018-06-19
     * 前台招聘列表张晓龙
     */
	public function index()
	{
		$region = new Region;
		$show = $region->show();
		$recruitment = new Recruitment;
		$recruitment_show = $recruitment->index();
		return view('home/notice/noticelist',['data' => $show,'recruitment' => $recruitment_show]);
	}
	/**
     * @
     * @DateTime  2018-06-19
     * 前台招聘详情张晓龙
     */
	public function notice()
  {
   	  $recruitment_id = Input::get('recruitment_id');
   	  $recruitment = new Recruitment;
   	  $notice = $recruitment->notice($recruitment_id);
   	  return view('home/notice/notice',['notice' => $notice]);
  }
  /**
     * @
     * @DateTime  2018-06-19
     * 前台招聘搜索张晓龙
     */
  public function noticeSearch()
  {
      $region_id = Input::get('region_id');
      $recruitment = new Recruitment;
      $recruitment_search = $recruitment->noticeSearch($region_id);
      if (empty($recruitment_search)) {
        $data['empty'] = 'empty';
      } else {
        $data['data'] = $recruitment_search;
      }
      return json_encode($data);
  }
}