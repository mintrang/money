<?php
//error_reporting(E_ALL);
//require("defined.php");
try {
	//read file config
	$config = new Phalcon\Config\Adapter\Ini('../app/config/config.ini');
	$loader = new \Phalcon\Loader();
	/**
	 * We're a registering a set of directories taken from the configuration file
	 */
	$loader->registerDirs(
		array(
			__DIR__ . $config->application->controllersDir,
			__DIR__ . $config->application->modelsDir,
		)
	)->register();

	//Create a DI
	$di = new Phalcon\DI\FactoryDefault();
	/**
	 * The URL component is used to generate all kind of urls in the application
	 */
//	$di->set('url', function () {
//		$url = new Phalcon\Mvc\Url();
//		$url->setBaseUri('//local.tutorial/');
//		return $url;
//	});

	$di->set('modelsManager', function() {
		return new Phalcon\Mvc\Model\Manager();
	});
//	Setup the database service
	$di->set('db', function () {
		return new \Phalcon\Db\Adapter\Pdo\Mysql(array(
			"host" => "localhost",
			"username" => "root",
			"password" => "123456",
			"dbname" => "tamtay",
			"charset" => "utf8"
		));
	});

	Phalcon\Mvc\Model::setup(array('phqlLiterals' => true));
	//Setup the view component
	$di->set('view', function () {
		$view = new \Phalcon\Mvc\View();
		$view->setViewsDir('../app/views/');
		return $view;
	});

	//Start the session the first time when some component request the session service
	$di->set('session', function () {
		$session = new Phalcon\Session\Adapter\Files();
		$session->start();
		return $session;
	});

	//Start the cookie the first time when some component request the session service
	$di->set('cookies', function () {
		$cookies = new Phalcon\Http\Response\Cookies();
		$cookies->useEncryption(false);
		return $cookies;
	});

	//Handle the requests
	$application = new \Phalcon\Mvc\Application($di);

	echo $application->handle()->getContent();

} catch (\Phalcon\Exception $e) {
	echo "PhalconException: ", $e->getMessage();
}