<?php
$this->breadcrumbs=array(
	'Services'=>array('index'),
	'Create',
);

$this->menu=array(
	array('label'=>'List Services', 'url'=>array('index')),
);
?>

<h1>Create new Service</h1>

<?php echo $this->renderPartial('_form', array('model'=>$model)); ?>
