<?php
namespace new1024php\library;

class Loader {

	/**
	 * [$debug debug开启状态]
	 * @var null
	 */
	public static $debug = null;

	/**
	 * [$route pathinfo路由]
	 * @var null
	 */
	public static $pathinfoRoute = null;

	/**
	 * [$annotationRoute 注解路由]
	 * @var null
	 */
	public static $annotationRoute = null;

	/**
	 * [$defController 默认的控制器]
	 * @var null
	 */
	public static $defController = null;

	/**
	 * [$defMethod 默认执行的方法]
	 * @var null
	 */
	public static $defMethod = null;

	/**
	 * [register 注册文件加载、路由]
	 * @Author   pengw
	 * @DateTime 2020-05-26T16:05:22+0800
	 * @param    array                    $config [description]
	 * @return   [type]                           [description]
	 */
	public static function register(array $config) {

		self::$debug           = $config['debug'] ?? false;
		self::$defController   = $config['defaultController'] ?? 'Main';
		self::$defMethod       = $config['defaultMethod'] ?? 'Index';
		self::$pathinfoRoute   = $config['pathinfo'];
		self::$annotationRoute = $config['annotation'];

		// 是否开启debug
		self::setDebug();
		// 系统自动加载
		spl_autoload_register([get_class(), 'autoload']);
		// 路由
		self::setRouter();
	}

	public static function autoload($className) {
		
		$controller = 'app\\controller\\'. $className . '.ctl.php';
			//$controller = 'D:\phpStudy1\WWW\study\new1024php\app\controller\MainController.php';
		if(!file_exists($controller)) {
			exit($controller . '  控制器文件不存在');
		}

		require $controller;
	}

	/**
	 * [setRouter 路由]
	 * @Author   pengw
	 * @DateTime 2020-05-26T14:52:52+0800
	 */
	public static function setRouter() {

		// 如果pathinfo路由和注解路由都开启，则优先选择pathinfo路由
		if(self::$pathinfoRoute) {
			// pathinfo 路由
			self::setPathInfoRoute();
			exit;
		}

		if(self::$annotationRoute) {
			// 注解路由
			self::setAnnotationRoute();
			exit;
		}
	}

	/**
	 * [setPathInfoRoute pathinfo路由]
	 * @Author   pengw
	 * @DateTime 2020-05-27T10:31:20+0800
	 */
	public static function setPathInfoRoute() {

		// 参数数组 /a/b
		$paramsArr = [];
		$url = $_SERVER['REQUEST_URI'];

		// 主页，不带任何参数，通过域名直接访问
		if($url == '/') {
			$controllerName = self::$defController . 'Controller';
			$methodName     = self::$defMethod;
		// 不带？参数
		}elseif(strpos($url, '?') === false) {
			// url中含有空字符
			$paramArray     = explode('/', $url);
			$controllerName = $paramArray[1] . 'Controller';
			$methodName     = $paramArray[2] ?? 'index';
			$paramsArr         = count($paramArray) > 3 ? array_slice($paramArray, 3) : [];
		
		}else{
			// 获取？之前的地址 不包括？和空字符
			$url = substr($url, 1, (strpos($url, '?') -1)); 

			$paramArray     = explode('/', $url);
			$controllerName = $paramArray[1] . 'Controller';
			$methodName     = $paramArray[2] ?? 'index';
			$paramsArr      = count($paramArray) > 2 ? array_slice($paramArray, 2) : [];
		}

		// 控制器文件路径
		$controllerFilePath = 'app\\controller\\' . $controllerName . '.ctl.php';

		// 控制器文件是否存在
		if(!file_exists($controllerFilePath)) {
			exit($controllerFilePath . '  控制器文件不存在');
		}
		
		// 控制器文件中的类是否存在
		if(!class_exists($controllerName)) {
			exit($controllerFilePath . '中类' . $controllerName . '不存在');
		}

		// 类中的方法是否存在
		if(!method_exists($controllerName, $methodName)) {
			exit($controllerFilePath . '中的方法' . $methodName . '()不存在');
		}

		$c = new $controllerName;

		call_user_func_array([$c, $methodName], $paramsArr);
	}

	/**
	 * [setAnnotationRoute 注解路由]
	 * @Author   pengw
	 * @DateTime 2020-05-27T10:31:48+0800
	 */
	public static function setAnnotationRoute() {

	}

	/**
	 * [setDebug 是否开启debug]
	 * @Author   pengw
	 * @DateTime 2020-05-26T11:52:32+0800
	 */
	public static function setDebug() {

		if(self::$debug) {
			error_reporting(E_ALL);
			ini_set('display_errors', 'on');
		}else{
			error_reporting(0);
			ini_set('display_errors', 'off');
		}
	}
}