<?php

namespace App\Http;

class Response
{

	public function redirect($url)
	{
		header("Location: /$url");
		header("Connection: close");
		exit;
	}

}