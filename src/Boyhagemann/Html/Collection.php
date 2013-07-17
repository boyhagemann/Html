<?php

namespace Boyhagemann\Html;

class Collection
{
	/**
	 * @var array
	 */
	protected $elements = array();

	/**
	 * @param array $elements
	 */
	public function setElements($elements)
	{
		$this->elements = $elements;
	}

	/**
	 * @return array
	 */
	public function getElements()
	{
		return $this->elements;
	}

	public function addElement($element)
	{
		$this->elements[] = $element;
	}

	/**
	 * @param $callback
	 * @throws \Exception
	 */
	public function each($callback)
	{
		if(!is_callable($callback)) {
			throw new \Exception('Must provide a valid callback');
		}

		foreach($this->getElements() as $element) {
			call_user_func_array($callback, array($element));
		}
	}


}