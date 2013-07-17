<?php

namespace Boyhagemann\Html;

require_once 'config.php';


$builder = new Builder;
$builder->insert($table = new Table, $tr = new Tr);

$tr->insert(new Td('test1'));
$tr->insert(new Td('test2'));
$tr->insert(new Td('test3'));
$tr->getValue()->each(function($td) {
	$td->attr('class', 'test');

	$td->insert($table2 = new Table);
	$table2->insert($tr2 = new Tr);
	$tr2->insert($td2 = new Td);
	$td2->setValue('test111');
});

$renderer = new Renderer;
$html = $renderer->render($table);

var_dump($html);

print $html;