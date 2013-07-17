
Html
====


## Examples

### Start with a new element
```
<?php

use Boyhagemann\Html\Table;

$table = new Table;
$table->attr('class', 'fancy-table');
```

### Use the builder to build html
You can insert new elements to a parent element
```
<?php

$builder new Builder;
$builder->insert(new Table, 'tr');
```

