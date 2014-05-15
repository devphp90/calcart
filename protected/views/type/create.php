<?php

$this->breadcrumbs=array(
	'Types'=>array('index'),
	'Create',
);

$this->menu=array(
	array('label'=>'List Type', 'url'=>array('index')),
);
?>
<h1>Create new Type</h1>

<?php echo $this->renderPartial('_form', array('model'=>$model)); ?>
