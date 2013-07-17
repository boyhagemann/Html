<?php

namespace Boyhagemann\Html;

class Renderer
{
	protected $engine;

	public function __construct()
	{
		$this->engine = new \DOMDocument('1.0', 'utf-8');
	}

	/**
	 * @param \DOMDocument $engine
	 */
	public function setEngine(\DOMDocument $engine) {
		$this->engine = $engine;
	}

	/**
	 * @return \DOMDocument
	 */
	public function getEngine() {
		return $this->engine;
	}

	/**
	 * @param Element $element
	 * @param \DOMNode $node
	 */
	protected function build(Element $element, \DOMNode $node)
	{
		$dom = $this->getEngine();

		if($element->getValue() instanceof Collection) {
			$newElement = $dom->createElement($element->getName());

			foreach($element->getValue()->getElements() as $child) {
				$this->build($child, $newElement);
			}

		}
		else {
			$newElement = $dom->createElement($element->getName(), $element->getValue()->getValue());
		}

		foreach($element->getAttributes()->getValues() as $attr => $value) {
			$newElement->setAttribute($attr, $value);
		}

		$node->appendChild($newElement);
	}

	/**
	 * @param Element $element
	 * @return string
	 */
	public function render(Element $element)
	{
		$dom = $this->getEngine();

		$this->build($element, $dom);

		return $dom->saveHTML();
	}
}