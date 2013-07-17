
Html
====



## The Html Elements
```
use Boyhagemann\Html\Table;

$table = new Table;
```

Change the attributes of an element
```
$table->attr('class', 'fancy-table');
```

You can insert a new element easy
```
$table->insert($tr = new Tr());
```

Insert an element with text
```
$tr->insert(new Td('This is a nice text');
```

You can edit each child element easily
```
$tr->eachChild(function($td, $i) {
	$td->attr('class', 'my-class')
	$td->setValue('My value ' . $i);
});
```

## The Html Builder
You can insert new elements to a parent element
```
use Boyhagemann\Html\Builder;

$builder new Builder;
$builder->insert(new Table, 'tr');
```

### Register custom elements to the builder

Register a callback, so you get a fresh instance every time
```
$builder->register('myCustomElement', function() {

	$element = new Element;
	$element->setName('thead');
	$element->attr('class', 'example-class');

	return $element;
}
```

Or register an instance to use the same instance every time
```
$builder->register('myTable', new Table);
```

Or register a class
```
$builder->register('myTd', 'Your\Html\Td');
```

Now we can use this element throughout the whole project.
```
$builder->register('table', new Table);

$table  = $builder->resolve('table');
$tr 	= $builder->resolve('tr');
$td 	= $builder->resolve('BoyHagemann\Html\Td');

$builder->insert('myTable', 'myCustomElement', function($thead) {
	$thead->insert(new Td('Title');
	$thead->insert(new Td('Description');
}
```


Or insert multiple elements and edit their properties
```
$builder->insertMultiple(new Table, 'tr', 5, function($tr) {

	// You can edit each table row now
	$tr->attr('class', 'my-row-class');
	$tr->insert(new Td('First value');
	$tr->insert(new Td('Second value');

});
```

## Render your html table as... html
```
use Boyhagemann\Html\Renderer;

$renderer = new Renderer;

// The result is a string with valid html
$html = $renderer->render($table);
```
