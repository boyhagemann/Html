<?php

namespace Boyhagemann\Html;

use Boyhagemann\Html\Elements\Td;
use Boyhagemann\Html\Elements\Tr;
use Boyhagemann\Html\Elements\Table;

require_once 'config.php';

$builder = new Builder;

$builder->instance('table', function() {
	$table = new Table;
	$table->attr('id', 'myTable');
	return $table;
});
$builder->instance('table');
$builder->register('thead', function() {
	$thead = new Element;
	$thead->setName('thead');
	$thead->append(new Td('Title'));
	$thead->append(new Td('Body'));
	return $thead;
});

$builder->append('table', 'thead', function($thead) {
	$thead->attr('class', 'test');
});
$builder->appendMany('table', 'tr', 5, function($tr, $i) {
	$tr->append(new Td('test' . $i, array('class' => 'test')));
	$tr->append(new Td('blaat' . $i));
});

$renderer = new Renderer;
$table = $builder->resolve('table');
$html = $renderer->render($table);

?>


<html>
	<head>
		<style>
			table {
				margin: 20px 0;
			}
			table tr td {
				padding: 15px;
			}
			td.test {
				background: #eee;
			}
		</style>
	</head>
	<body>

		<pre><?php var_dump($html) ?></pre>
		<?php echo $html ?>
	</body>
</html>