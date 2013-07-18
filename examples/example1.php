<?php

namespace Boyhagemann\Html;

use Boyhagemann\Html\Elements\Td;
use Boyhagemann\Html\Elements\Tr;
use Boyhagemann\Html\Elements\Table;

require_once 'config.php';

$builder = new Builder;

$builder->register('thead', function() {
	$thead = new Element;
	$thead->setName('thead');
	$thead->insert(new Td('Title'));
	$thead->insert(new Td('Body'));
	return $thead;
});

$builder->insert('table', 'thead', function($thead) {
	$thead->attr('class', 'test');
});
$builder->insertMultiple('table', 'Boyhagemann\Html\Elements\Tr', 5, function($tr, $i) {
	$tr->insert(new Td('test' . $i, array('class' => 'test')));
	$tr->insert(new Td('blaat' . $i));
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