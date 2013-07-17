<?php

namespace Boyhagemann\Html;

class Attributes
{
	/**
	 * @var array
	 */
	protected $values = array();

	/**
	 * @param array $values
	 */
	public function setValues($values) {
		$this->values = $values;
	}

	/**
	 * @return array
	 */
	public function getValues() {
		return $this->values;
	}

	/**
	 * @param $name
	 * @param $value
	 */
	public function set($name, $value)
	{
		$this->values[$name] = $value;
	}

	/**
	 * @param $name
	 * @return mixed
	 */
	public function get($name)
	{
		return $this->values[$name];
	}

}