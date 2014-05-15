<?php
$this->breadcrumbs=array(
	'Types'=>array('index'),
	'Type ID #'.$model->id=>array('view','id'=>$model->id),
	'Update',
);

$this->menu=array(
	array('label'=>'List Types', 'url'=>array('index')),
	array('label'=>'Create Type', 'url'=>array('create')),
	array('label'=>'View Type', 'url'=>array('view', 'id'=>$model->id)),
);
?>


<h1>Update Type ID # <?php echo $model->id; ?></h1>

<?php echo $this->renderPartial('_form', array('model'=>$model)); ?>
