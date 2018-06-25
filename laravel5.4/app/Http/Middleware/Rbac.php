<?php

namespace App\Http\Middleware;

use Closure;
use DB;
use Session;

class Rbac
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {   
        //获取当前访问的路由
        $method = request()->route()->getActionName();
        
        //截取控制器加方法
        $str = strripos($method,"\\")+1;
        $jurisdiction_urls = substr($method,$str);
        //根据当前路由查询数据库
        $data = DB::table('jurisdiction')->where('jurisdiction_url',$jurisdiction_urls)->first();
        //验证没有数据添加数据到数据库
        if(!$data){
            DB::table('jurisdiction')->insert(['jurisdiction_url'=>$jurisdiction_urls]);
        }
        //获取管理员id
        $admin_id = session('data')['admin_id'];
        //根据管理员id获取角色id
        $role_id = DB::table('admin_role')->select('role_id')->where('admin_id',$admin_id)->first();
        //根据角色id获取所有权限id
        $jurisdiction_id = DB::table('role_jurisdiction')->where('role_id',$role_id->role_id)->pluck('jurisdiction_id')->toArray();
        //根据权限id获取所有权限
        $jurisdiction_url = DB::table('jurisdiction')->select('jurisdiction_url')->whereIn('jurisdiction_id',$jurisdiction_id)->get();
        // dd($jurisdiction_url);die;
        // dd($jurisdiction_urls);die;
        //判断是否拥有权限
        foreach ($jurisdiction_url as $key => $val) {
            if($val->jurisdiction_url == $jurisdiction_urls){
                return $next($request); 
            }
        }
        echo '没有权限';die;  
       
    }
}
