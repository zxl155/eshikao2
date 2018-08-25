<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Default Filesystem Disk
    |--------------------------------------------------------------------------
    |
    | Here you may specify the default filesystem disk that should be used
    | by the framework. The "local" disk, as well as a variety of cloud
    | based disks are available to your application. Just store away!
    |
    */

    'default' => env('FILESYSTEM_DRIVER', 'local'),

    /*
    |--------------------------------------------------------------------------
    | Default Cloud Filesystem Disk
    |--------------------------------------------------------------------------
    |
    | Many applications store files both locally and in the cloud. For this
    | reason, you may specify a default "cloud" driver here. This driver
    | will be bound as the Cloud disk implementation in the container.
    |
    */

    'cloud' => env('FILESYSTEM_CLOUD', 's3'),

    /*
    |--------------------------------------------------------------------------
    | Filesystem Disks
    |--------------------------------------------------------------------------
    |
    | Here you may configure as many filesystem "disks" as you wish, and you
    | may even configure multiple disks of the same driver. Defaults have
    | been setup for each driver as an example of the required options.
    |
    | Supported Drivers: "local", "ftp", "s3", "rackspace"
    |
    */

    'disks' => [

        'local' => [
            'driver' => 'local',
            'root' => storage_path('app'),
        ],

        'public' => [
            'driver' => 'local',
            'root' => storage_path('app/public'),
            'url' => env('APP_URL').'/storage',
            'visibility' => 'public',
        ],

        's3' => [
            'driver' => 's3',
            'key' => env('AWS_KEY'),
            'secret' => env('AWS_SECRET'),
            'region' => env('AWS_REGION'),
            'bucket' => env('AWS_BUCKET'),
        ],
        //定义文章图片路径 前台用户头像
         'article'=>[ 
           'driver'=>'local',
           'root' =>public_path('home/img/head/')
       ],
       //定义文章图片路径 后台管理员头像
         'articles'=>[
           'driver'=>'local',
           'root' =>public_path('home/img/admin_head/')
       ],
       //定义文章图片路径 后台轮播图管理
         'sowing_msp'=>[
           'driver'=>'local',
           'root' =>public_path('home/img/sowing_msp/')
       ],
        //定义文章图片路径 后台轮播图管理
         'curriculum_pricture'=>[
           'driver'=>'local',
           'root' =>public_path('home/img/curriculum_pricture/')
       ],
       //定义招聘公告文件路径
         'recruitment'=>[
           'driver'=>'local',
           'root' =>public_path('home/img/recruitment/')
       ],
       //直播讲义文件路径
         'jianyi'=>[
           'driver'=>'local',
           'root' =>public_path('home/img/jianyi/')
       ],
    ],

];
