<?php

namespace Boyhagemann\Html;

class Builder
{
	public function insert(Element $root, Element $element)
	{
		$root->getValue()->addElement($element);
	}
}