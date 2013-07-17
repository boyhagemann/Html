<?php

namespace Boyhagemann\Html;

require_once 'config.php';

$builder = new Builder;

$builder->register('myTable', new Table);
$builder->register('thead', function() {
	$thead = new Element;
	$thead->setName('thead');
	$thead->insert(new Td('Title'));
	$thead->insert(new Td('Body'));
	return $thead;
});

$builder->insert('myTable', 'thead', function($thead) {
	$thead->attr('class', 'test');
});
$builder->insertMultiple('myTable', 'Boyhagemann\Html\Tr', 5, function($tr, $i) {
	$tr->insert(new Td('test' . $i, array('class' => 'test')));
	$tr->insert(new Td('blaat' . $i));
});

$renderer = new Renderer;
$table = $builder->resolve('myTable');
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