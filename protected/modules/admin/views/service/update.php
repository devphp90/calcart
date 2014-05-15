<?php
$this->breadcrumbs=array(
	'Services'=>array('index'),
	'Service ID #'.$model->id=>array('view','id'=>$model->id),
	'Update',
);

$this->menu=array(
	array('label'=>'List Services', 'url'=>array('index')),
	array('label'=>'Create Service', 'url'=>array('create')),
	array('label'=>'View Service', 'url'=>array('view', 'id'=>$model->id)),
);
?>

<h1>Update Service ID # <?php echo $model->id; ?></h1>

<?php echo $this->renderPartial('_form', array('model'=>$model)); ?>
