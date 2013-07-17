<?php

namespace Boyhagemann\Html;

class Builder
{
	/**
	 * @var array
	 */
	protected $elements;

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