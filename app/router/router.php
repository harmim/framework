<?php

namespace App\Router;

use App;


/**
 * @author Dominik Harmim <harmim6@gmail.com>
 */
class Router
{

	/** @var string */
	protected $url;

	/** @var App\Http\Response */
	private $httpResponse;


	public function __construct($url)
	{
		$this->url = $url;
		$this->httpResponse = new App\Http\Response();
	}


	public function createRouter()
	{
		$path = $this->parseUrl($this->url);

		if (empty($path)) {
			$this->httpResponse->redirect('homepage');
		}

		$controllerClass = 'App\\Controllers\\' . $this->kebabCaseToCamelCase(array_shift($path)) . 'Controller';

		if ( ! class_exists($controllerClass)) {
			if ( ! class_exists('App\\Controllers\\ErrorController')) {
				throw new \Exception('App\\Controllers\\ErrorController not found.');
			}
			$this->httpResponse->redirect('error');
		}

		/** @var App\Controllers\BaseController $controller */
		$controller = new $controllerClass;
		$controller->process($path);
		$controller->render();
	}


	/**
	 * @param string $url
	 * @return array
	 */
	private function parseUrl($url)
	{
		$parsedUrl = parse_url($url);
		$path = trim(ltrim($parsedUrl['path'], '/'));
		$path = explode('/', $path);

		return array_filter($path);
	}


	/**
	 * @param string $text
	 * @return string
	 */
	private function kebabCaseToCamelCase($text)
	{
		$ret = str_replace('-', ' ', $text);
		$ret = ucwords($ret);
		$ret = str_replace(' ', '', $ret);

		return $ret;
	}

}
