<?php
/**
 * 框架入口
 * @author pengw
 * @since  2020-05-26
 */

// 当前应用的目录
define('APP_PATH', __DIR__ . '/');

// 加载loader.php
require APP_PATH . 'new1024php/library/loader.php';

// 加载框架核心文件 new1024php/base.php
require APP_PATH . 'new1024php/base.php';

// 加载配置文件 config/config.php
require APP_PATH . 'config/config.php';

// 运行框架
(new new1024php\Base($cnf))->run();