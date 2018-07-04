<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Input;
use App\Admin\Models\Broadcast;
use Session;
use DB;
class CommonController extends Controller
{

    public function __construct(){

        $this->middleware(function ($request, $next) {
           $data =  $request->session()->get('data');
           $admin_id = $data->admin_id;

            $action=\Route::current()->getActionName();
            list($class,$action)=explode('@',$action);
           //控制器名     
            $controller=substr(strrchr($class,'\\'),1);
            $controller=substr($controller,0,-10);
           
            $admin=DB::table('admin_role')->where('admin_id',$admin_id)->get(); 
            $role_id = $admin[0]->role_id; //角色id
            if ($controller == 'Index' & $action == 'index') {
                return $next($request);
            }
            if ($controller == 'Index' & $action == 'personal') {
                return $next($request);
            }
            if ($controller == 'Index' & $action == 'upd') {
                return $next($request);
            }
             if ($controller == 'Index' & $action == 'upds') {
                return $next($request);
            }
             if ($controller == 'Index' & $action == 'pwd') {
                return $next($request);
            }
             if ($controller == 'Index' & $action == 'pwds') {
                return $next($request);
            }
            if($role_id== 1){
                return $next($request);
            }
             $jurisdiction_id=DB::table('role_jurisdiction')->where('role_id',$role_id)->get();
             foreach ($jurisdiction_id as $key => $value) {
                 $arr[] = $value->jurisdiction_id;
             }
             $jurisdiction_id = implode(',',$arr);
             $data = DB::select("select * from jurisdiction where jurisdiction_id in($jurisdiction_id)");
                $data=json_decode(json_encode($data),true);
                foreach($data as $k=>$v){
                    $arr[]=$v['jurisdiction_name']."/".$v['jurisdiction_url'];
                }
                if(!in_array($controller."/".$action,$arr)){
                     $url = "{{URL::asset('admin/index')}}";  
                    echo "<script>alert('没有访问权限！！！！');location.href='http://www.eshikaojiaoyu.com/admin/index';</script>";
                 
                } else {
                    return $next($request);
                }
            
            
            
        });
      

}

}