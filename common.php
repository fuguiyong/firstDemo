<?php
// +----------------------------------------------------------------------
// | ThinkPHP [ WE CAN DO IT JUST THINK ]
// +----------------------------------------------------------------------
// | Copyright (c) 2006-2016 http://thinkphp.cn All rights reserved.
// +----------------------------------------------------------------------
// | Licensed ( http://www.apache.org/licenses/LICENSE-2.0 )
// +----------------------------------------------------------------------
// | Author: 流年 <liu21st@gmail.com>
// +----------------------------------------------------------------------
use think\Session;
use app\weixin\exClass\weixin\WeAuthorize;//授权服务类
// 应用公共文件
 function sayHello()
{
  echo "hello";
}

//自动登录函数
//用户自动登录
 function login($url)
{
  //先判断是否登录
  //如果没登陆，判断是否带参数code，是=》获取信息并且登录 ，否=》授权回调
  if(Session::has('user')){
    // file_put_contents('user.txt','has user');
  }else{
    //实例化授权类
    $urlAuth = new WeAuthorize(APPID,APPSECRET);
    if(input('get.code')!=null){//用户已经回调了，直接获取信息
      $userInfo = $urlAuth->get_user_info();
      $user = [
        'openid'=>$userInfo['openid'],
        'nickname'=>$userInfo['nickname'],
        'sex'=>$userInfo['sex'],
        'headimgurl'=>$userInfo['headimgurl']
      ];
      //设置用户登录信息
      Session::set('user',$user);
    }else{//授权回调
      //动态获取当前的url
      // $url = 'http'.$_SERVER['REQUEST_SCHEME'] . '://' . $_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI'];
      // $url = 'http://www.kangquanpay.top/pay';
      $redurl = $urlAuth->get_authorize_url($url);
      //构建跳转地址 跳转
      header("location:{$redurl}");
    }
  }
}

?>
