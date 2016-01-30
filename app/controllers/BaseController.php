<?php

namespace App\Controllers;


abstract class BaseController
{

	/** @var array */
	protected $templateDate = [];

	/** @var array */
	protected $layoutData = [];


	/**
	 * @param array $path
	 */
	abstract public function process(array $path);


	/**
	 * @return array
	 */
	protected function prepareTemplateData()
	{

	}


	/**
	 * @return array
	 */
	protected function prepareLayoutData()
	{
		$this->layoutData += [
			'title' => 'MVC Framework',
			'templateName' => $this->getTemplateName(),
		];
	}


	public function render($template = 'layout')
	{
		$templatePath = VIEW_DIR . "/$template.phtml";
		if (file_exists($templatePath)) {
			if ($template === 'layout') {
				$this->prepareLayoutData();
				$data = $this->layoutData;
			} else {
				$this->prepareTemplateData();
				$data = $this->templateDate;
			}
			if ($data) {
				extract($this->escape($data));
				extract($data, EXTR_PREFIX_ALL, "");
			}
			require $templatePath;
		} else {
			throw new \Exception("Template $template.phtml not found.");
		}
	}


	protected function getTemplateName()
	{
		$reflection = new \ReflectionClass($this);
		preg_match('~^(.+)Controller~', $reflection->getShortName(), $mathes);

		return mb_strtolower($mathes[1]);
	}


	protected function escape($data)
	{
		if (is_array($data)) {
			$escapedData = [];
			foreach ($data as $key => $value) {
				$escapedData[$key] = $this->escape($value);
			}

			return $escapedData;
		}

		return htmlspecialchars($data, ENT_QUOTES);
	}

}
