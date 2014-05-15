<?php
$this->breadcrumbs=array(
	'Tenants'=>array('index'),
	$model->username=>array('view','id'=>$model->id),
	'Update',
);

/*$this->menu=array(
	array('label'=>'List User', 'url'=>array('index')),
	array('label'=>'Create User', 'url'=>array('create')),
	array('label'=>'View User', 'url'=>array('view', 'id'=>$model->id)),
	array('label'=>'Manage User', 'url'=>array('admin')),
);*/
?>

<h1>Update <?php echo $model->username; ?></h1>

<?php echo $this->renderPartial('_form', array('model'=>$model)); ?>