<?php

namespace Boyhagemann\Html;

class Builder
{
	/**
	 * @var array
	 */
	protected $elements = array(
		'address' 	=> 'Boyhagemann\Html\Elements\Address',
		'article' 	=> 'Boyhagemann\Html\Elements\Article',
		'aside' 	=> 'Boyhagemann\Html\Elements\Aside',
		'base' 		=> 'Boyhagemann\Html\Elements\Base',
		'body' 		=> 'Boyhagemann\Html\Elements\Body',
		'footer' 	=> 'Boyhagemann\Html\Elements\Footer',
		'h1' 		=> 'Boyhagemann\Html\Elements\H1',
		'h2' 		=> 'Boyhagemann\Html\Elements\H2',
		'h3' 		=> 'Boyhagemann\Html\Elements\H3',
		'h4' 		=> 'Boyhagemann\Html\Elements\H4',
		'h5' 		=> 'Boyhagemann\Html\Elements\H5',
		'h6' 		=> 'Boyhagemann\Html\Elements\H6',
		'head' 		=> 'Boyhagemann\Html\Elements\Head',
		'header' 	=> 'Boyhagemann\Html\Elements\Header',
		'html' 		=> 'Boyhagemann\Html\Elements\Html',
		'link' 		=> 'Boyhagemann\Html\Elements\Link',
		'main' 		=> 'Boyhagemann\Html\Elements\Main',
		'meta' 		=> 'Boyhagemann\Html\Elements\Meta',
		'nav' 		=> 'Boyhagemann\Html\Elements\Nav',
		'noscript'	=> 'Boyhagemann\Html\Elements\Noscript',
		'script' 	=> 'Boyhagemann\Html\Elements\Script',
		'section' 	=> 'Boyhagemann\Html\Elements\Section',
		'style' 	=> 'Boyhagemann\Html\Elements\Style',
		'table' 	=> 'Boyhagemann\Html\Elements\Table',
		'td' 		=> 'Boyhagemann\Html\Elements\Td',
		'title' 	=> 'Boyhagemann\Html\Elements\Title',
		'tr' 		=> 'Boyhagemann\Html\Elements\Tr',
	);

	/**
	 * @param $name
	 * @param $callbackOrInstance
	 */
	public function register($name, $callbackOrInstance)
	{
		$this->elements[$name] = $callbackOrInstance;
	}

	/**
	 * @param $name
	 * @return mixed
	 * @throws \Exception
	 */
	public function resolve($name)
	{
		if($name instanceof Element) {
			return $name;
		}

		if(isset($this->elements[$name])) {

			if($this->elements[$name] instanceof Element) {
				return $this->elements[$name];
			}

			if(is_callable($this->elements[$name])) {
				return call_user_func($this->elements[$name]);
			}
		}

		if(class_exists($name)) {
			return new $name;
		}

		throw new \Exception(sprintf('Element "%s" could not be resolved', $name));
	}

	/**
	 * @param Element $root
	 * @param $elementName
	 */
	public function insert($rootName, $elementName, $callback = null)
	{
		$root = $this->resolve($rootName);
		$element = $this->resolve($elementName);

		$root->getValue()->addElement($element);

		if($callback && is_callable($callback)) {
			call_user_func_array($callback, array($element));
		}
	}

	/**
	 * @param $rootName
	 * @param $elementName
	 * @param $count
	 * @param $callback
	 */
	public function insertMultiple($rootName, $elementName, $count, $callback)
	{
		$root = $this->resolve($rootName);

		for($i = 0; $i < $count; $i++) {
			$element = $this->resolve($elementName);
			call_user_func_array($callback, array($element, $i));
			$root->insert($element);
		}
	}
}