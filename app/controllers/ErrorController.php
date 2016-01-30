<?php

namespace App\Controllers;

class ErrorController extends BaseController
{

	/**
	 * @inheritdoc
	 */
	public function process(array $path)
	{
		header("HTTP/1.0 404 Not Found");
	}

}
