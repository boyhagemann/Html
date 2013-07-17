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
	 * @param $callback
	 */
	public function registerElement($name, $callback)
	{
		$this->elements[$name] = $callback;
	}

	/**
	 * @param $name
	 * @return mixed
	 * @throws \Exception
	 */
	public function getElement($name)
	{
		if(isset($this->elements[$name])) {
			return call_user_func($this->elements[$name]);
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
	public function insert(Element $root, $elementName, $callback = null)
	{
		$element = $this->getElement($elementName);
		$root->getValue()->addElement($element);

		if($callback && is_callable($callback)) {
			call_user_func_array($callback, array($element));
		}
	}

	/**
	 * @param Element $root
	 * @param 		  $elementName
	 * @param         $count
	 * @param         $callback
	 */
	public function insertMultiple(Element $root, $elementName, $count, $callback)
	{
		for($i = 0; $i < $count; $i++) {
			$element = $this->getElement($elementName);
			call_user_func_array($callback, array($element, $i));
			$root->insert($element);
		}
	}
}