<?php

namespace Boyhagemann\Html;

class Collection
{
	const POSITION_BEFORE 	= 'before';
	const POSITION_AFTER	= 'after';

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

	/**
	 * @param $element
	 * @param $position
	 * @throws \Exception
	 */
	public function addElement($element, $position)
	{
		switch($position) {

			case self::POSITION_BEFORE:
				array_unshift($this->elements, $element);
				break;

			case self::POSITION_AFTER:
				$this->elements[] = $element;
				break;

			default:
				throw new \Exception('Not a correct position given');
		}
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