<?php
$this->breadcrumbs=array(
	'Orders'=>array('index'),
	'Create',
);

$this->menu=array(
	array('label'=>'List Orders', 'url'=>array('index')),
);
?>

<h1>Create new Order</h1>

<?php echo $this->renderPartial('_form', array('model'=>$model)); ?>
