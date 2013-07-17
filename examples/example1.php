<?php

namespace Boyhagemann\Html;

require_once 'config.php';

$builder = new Builder;

$builder->registerElement('thead', function() {
	$thead = new Element;
	$thead->setName('thead');
	return $thead;
});

$table = new Table;
$builder->insert($table, 'thead', function($thead) {
	$thead->attr('class', 'test');
	$thead->insert(new Td('Title'));
	$thead->insert(new Td('Body'));
});
$builder->insertMultiple($table, 'Boyhagemann\Html\Tr', 5, function($tr, $i) {
	$tr->insert(new Td('test' . $i, array('class' => 'test')));
	$tr->insert(new Td('blaat' . $i));
});

$renderer = new Renderer;
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