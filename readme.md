
Html
====

This package makes it easy to build up html elements in PHP in a Object Oriented way.
It allowes you to manipulate the basic html structure as easy and managable as possible.
After the html is setup, it can be rendered as a string.

The package is divided in three parts:

* [Elements] (#the-elements)
* [Builder] (#the-html-builder)
* [Renderer] (#the-renderer)

## The Elements

This package comes is built on a simple Element class.
It has attributes and can hold other elements nested as children.

### Using the elements

Starting with a new element is simple
```php
use Boyhagemann\Html\Table;

$table = new Table;
```

Change the attributes of an element
```php
$table->attr('class', 'fancy-table');
```

You can insert a new element easy
```php
$table->insert($tr = new Tr());
```

Insert an element with text
```php
$tr->insert(new Td('This is a nice text');
```

You can edit each child element easily
```php
$tr->eachChild(function($td, $i) {
	$td->attr('class', 'my-class')
	$td->setValue('My value ' . $i);
});
```

## The Html Builder
You can insert new elements to a parent element
```php
use Boyhagemann\Html\Builder;

$builder new Builder;
$builder->insert(new Table, 'tr');
```

### Register custom elements to the builder

Register a callback, so you get a fresh instance every time
```php
$builder->register('myCustomElement', function() {

	$element = new Element;
	$element->setName('thead');
	$element->attr('class', 'example-class');

	return $element;
}
```

Or register an instance to use the same instance every time
```php
$builder->register('myTable', new Table);
```

Or register a class
```php
$builder->register('myTd', 'Your\Html\Td');
```

### Use the registered elements

Now we can use this element throughout the whole project.
```php
$builder->register('table', new Table);

$table  = $builder->resolve('table');
$tr 	= $builder->resolve('tr');
$td 	= $builder->resolve('BoyHagemann\Html\Td');
```

We can use it to insert elements
```php
$builder->insert('myTable', 'myCustomElement', function($thead) {
	$thead->insert(new Td('Title');
	$thead->insert(new Td('Description');
}
```

Or insert multiple elements and edit their properties
```php
$builder->insertMultiple('myTable', 'tr', 5, function($tr) {

	// You can edit each table row now
	$tr->attr('class', 'my-row-class');
	$tr->insert(new Td('First value');
	$tr->insert(new Td('Second value');

});
```


## The renderer

Render your html table as... html
```php
use Boyhagemann\Html\Renderer;

$renderer = new Renderer;

// The result is a string with valid html
$html = $renderer->render($table);
```
