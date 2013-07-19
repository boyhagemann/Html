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
		'thead' 	=> 'Boyhagemann\Html\Elements\Thead',
	);

	/**
	 * @param $name
	 * @return bool
	 */
	public function has($name)
	{
		return isset($this->elements[$name]);
	}

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
	 * @param $callbackOrInstance
	 * @return Element
	 */
	public function instance($name, $callbackOrInstance = null)
	{
		if(!$this->has($name) && $callbackOrInstance) {
			$this->register($name, $callbackOrInstance);
		}

		$element = $this->resolve($name);
		$this->elements[$name] = $element;

		return $element;
	}

	/**
	 * @param $name
	 * @return mixed
	 * @throws \Exception
	 */
	public function resolve($name)
	{
		$element = null;


		if($name instanceof Element) {
			$element = $name;
		}
		elseif(isset($this->elements[$name])) {

			if($this->elements[$name] instanceof Element) {
				$element = $this->elements[$name];
			}
			elseif(is_callable($this->elements[$name])) {
				$element = call_user_func($this->elements[$name]);
			}
			elseif(class_exists($this->elements[$name])) {
				$element = new $this->elements[$name];
			}
		}
		elseif(class_exists($name)) {
			$element = new $name;
		}

		if(!$element instanceof Element) {
			throw new \Exception(sprintf('Element "%s" could not be resolved', $name));
		}

		$element->setBuilder($this);

		return $element;
	}

	/**
	 * @param $rootName
	 * @param $text
	 * @return Element
	 */
	public function text($rootName, $text)
	{
		$root = $this->resolve($rootName);
		$root->setValue($text);

		return $root;
	}

	public function prepend($rootName, $elementName, $callback = null)
	{
		return $this->insert($rootName, $elementName, 'before', $callback);
	}

	public function append($rootName, $elementName, $callback = null)
	{
		return $this->insert($rootName, $elementName, 'after', $callback);
	}

	public function prependMany($rootName, $elementName, $count, $callback = null)
	{
		return $this->insertMultiple($rootName, $elementName, $count, 'before', $callback);
	}

	public function appendMany($rootName, $elementName, $count, $callback = null)
	{
		return $this->insertMultiple($rootName, $elementName, $count, 'after', $callback);
	}

	/**
	 * @param Element $root
	 * @param $elementName
	 * @param $position
	 * @param $callback
	 */
	protected function insert($rootName, $elementName, $position, $callback = null)
	{
		$root = $this->resolve($rootName);
		$element = $this->resolve($elementName);

		$root->getValue()->addElement($element, $position);

		if($callback && is_callable($callback)) {
			call_user_func_array($callback, array($element));
		}

		return $element;
	}

	/**
	 * @param $rootName
	 * @param $elementName
	 * @param $count
	 * @param $position
	 * @param $callback
	 */
	protected function insertMultiple($rootName, $elementName, $count, $position, $callback)
	{
		$root = $this->resolve($rootName);

		for($i = 0; $i < $count; $i++) {
			$element = $this->resolve($elementName);

			if($callback && is_callable($callback)) {
				call_user_func_array($callback, array($element, $i));
			}

			$this->insert($root, $element, $position);
		}
	}
}