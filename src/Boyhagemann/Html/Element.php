<?php

namespace Boyhagemann\Html;

class Element
{
	/**
	 * @var string
	 */
	protected $name;

	/**
	 * @var \Boyhagemann\Html\Element
	 */
	protected $parent;

	/**
	 * @var \Boyhagemann\Html\Collection|string
	 */
	protected $value;

	protected $attributes;

	/**
	 *
	 * @param mixed $value
	 */
	public function __construct($value = null)
	{
		if(!$value) {
			$value = new Collection;
		}

		$this->setValue($value);

		$this->attributes = new Attributes;
	}

	/**
	 * @param mixed $name
	 */
	public function setName($name)
	{
		$this->name = $name;
	}

	/**
	 * @return mixed
	 */
	public function getName()
	{
		return $this->name;
	}

	/**
	 * @param Attributes $attributes
	 */
	public function setAttributes(Attributes $attributes) {
		$this->attributes = $attributes;
	}

	/**
	 * @return mixed
	 */
	public function getAttributes() {
		return $this->attributes;
	}

	/**
	 * @param \Boyhagemann\Html\Collection|string $value
	 * @return \Boyhagemann\Html\Element
	 */
	public function setValue($value) {

		if(!is_string($value) && !$value instanceof Collection) {
			throw new \Exception('Can only use a string or \Boyhagemann\Html\Collection as a value');
		}

		if(is_string($value)) {
			$value = new Text($value);
		}
		$this->value = $value;
		return $this;
	}

	/**
	 * @param $name
	 * @param $value
	 */
	public function attr($name, $value)
	{
		$this->getAttributes()->set($name, $value);
	}

	/**
	 * @return \Boyhagemann\Html\Collection|string
	 */
	public function getValue() {
		return $this->value;
	}

	/**
	 * @param \Boyhagemann\Html\Element $parent
	 */
	public function setParent(Element $parent) {
		$this->parent = $parent;
	}

	/**
	 * @return \Boyhagemann\Html\Element
	 */
	public function getParent() {
		return $this->parent;
	}


	/**
	 * @param \Boyhagemann\Html\Element $element
	 * @return \Boyhagemann\Html\Element
	 */
	public function insert(Element $element)
	{
		if(!$this->getValue() instanceof Collection) {
//			throw new \Exception('Cannot add element because a text value is already set');
			return;
		}

		$this->getValue()->addElement($element);
		return $this;
	}
}