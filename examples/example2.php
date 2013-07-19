<?php

namespace Boyhagemann\Html;

require_once 'config.php';

$builder = new Builder;

$builder->instance('table')->append('tr')->appendMany('td', 5, function($td) {
	$td->text('Test');
});
$builder->instance('table')->prepend('thead', function($thead) {
	$thead->append('td')->text('Title');
	$thead->append('td')->text('Body');
	$thead->append('td')->text('Test 3');
	$thead->append('td')->text('Test 4');
	$thead->append('td')->text('Test 5');
});



$renderer = new Renderer;
$html = $renderer->render($builder->resolve('table'));

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
		</style>
	</head>
	<body>

		<pre><?php var_dump($html) ?></pre>
		<?php echo $html ?>
	</body>
</html>