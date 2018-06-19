<?php

namespace App\Home\Models;

use Illuminate\Database\Eloquent\Model;
use DB;

class Recruitment extends Model
{
   public function index()
   {
      $arr = DB::select('select * from recruitment order by add_time desc ');
      $region = DB::select('select * from region ');
      foreach ($arr as $key => $value) {
			$value->year = substr($value->add_time, 0,4);
			$value->month = substr($value->add_time, 5,2);
			$value->day = substr($value->add_time, 8,2);
		}
		foreach ($arr as $key => $value) {
			foreach ($region as $keys => $values) {
				if ($value->region_id == $values->region_id) {
					$value->region_name = $values->region_name;
				}
			}
		}
      return $arr;
   }
  public function notice($recruitment_id)
  {
  	 $arr = DB::select("select * from recruitment where recruitment_id = $recruitment_id");
  	 $region = DB::select('select * from region ');
      foreach ($arr as $key => $value) {
			$value->year = substr($value->add_time, 0,4);
			$value->month = substr($value->add_time, 5,2);
			$value->day = substr($value->add_time, 8,2);
		}
		foreach ($arr as $key => $value) {
			foreach ($region as $keys => $values) {
				if ($value->region_id == $values->region_id) {
					$value->region_name = $values->region_name;
				}
			}
		}
  	 return $arr;
  }
  public function noticeSearch($region_id)
  {
  	if ($region_id == '0') {
  		 $arr = DB::select("select * from recruitment");
        $region = DB::select('select * from region ');
      foreach ($arr as $key => $value) {
      $value->year = substr($value->add_time, 0,4);
      $value->month = substr($value->add_time, 5,2);
      $value->day = substr($value->add_time, 8,2);
    }
    foreach ($arr as $key => $value) {
      foreach ($region as $keys => $values) {
        if ($value->region_id == $values->region_id) {
          $value->region_name = $values->region_name;
        }
      }
    }
  	  	return $arr;
  	} else {
  		 $arr = DB::select("select * from recruitment where region_id = $region_id");
        $region = DB::select('select * from region ');
      foreach ($arr as $key => $value) {
      $value->year = substr($value->add_time, 0,4);
      $value->month = substr($value->add_time, 5,2);
      $value->day = substr($value->add_time, 8,2);
    }
    foreach ($arr as $key => $value) {
      foreach ($region as $keys => $values) {
        if ($value->region_id == $values->region_id) {
          $value->region_name = $values->region_name;
        }
      }
    }
  	  	return $arr;
  	}
  	 
  }
}
