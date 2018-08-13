<?php
namespace app\index\controller;

use think\Controller;
use think\Session;
use app\index\model\UserInfo;//用户模型
use aliyunSms\SendMsg;//阿里云

// use smsDemo\smsyzm;//云之讯

class Register extends Controller
{
  //注册首页
  public function register()
  {
    //用户自动登录
    $url = 'http://www.kangquanpay.top/register';
    $userLogin = \think\Loader::model('User','logic');
    $userLogin->login($url);//因为动态地址获取不行，所以为了通用就传入redirect_url
    //返回页面
    return view('register');
  }

  //验证码获取ajax
  public function getValid()
  {
    //----------阿里云---------
    $sms = new SendMsg();
    return $sms->sendValid();
    //----------云之讯--------
    // $sms = new smsyzm();
    // //执行验证码的发送，并且返回前端json数据
    // return $sms->sendValid();//返回给前端json数据
  }

  //注册表单
  public function kangquanRegister()
  {
    $userRegister = \think\Loader::model('User','logic');
    //执行注册并且放回前端json数据
    return $userRegister->register();
  }

}
 ?>