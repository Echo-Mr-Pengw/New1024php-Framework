<?php
namespace new1024php;
use new1024php\library\Loader;

class Base {

	/**
	 * [$config 保存配置信息]
	 * @var array
	 */
	public $config = [];

	public function __construct(array $cnf) {
		$this->config = $cnf;
		
	}

	public function __destruct() {}

	public function run() {
		Loader::register($this->config);
	}
}