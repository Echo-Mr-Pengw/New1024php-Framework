<?php
/**
 * 配置文件
 */

// ************************
//	  数据库配置
// ***********************
// host
$cnf['db']['host'] = 'localhost';  
// 端口
$cnf['db']['port'] = 3306;
// 用户
$cnf['db']['username'] = 'root';
// 密码
$cnf['db']['password'] = 123456;
// 数据库
$cnf['db']['database'] = 'new1024php';

// **************************
//      默认控制器和方法
// **************************
// 控制器
$cnf['defaultController'] = 'Main';
// 方法
$cnf['defaultMethod'] = 'Index';


// **************************
//       是否开启debug
// **************************
$cnf['debug'] = true;

// **************************
//          路由
// **************************
// pathinfo路由 true为开启，false为关闭
$cnf['pathinfo'] = true;
// 注解路由  true为开启，false为关闭
$cnf['annotation'] = false;


