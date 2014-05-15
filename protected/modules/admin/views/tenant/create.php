<?php
$this->breadcrumbs=array(
	'Tenants'=>array('index'),
	'Create',
);

/*$this->menu=array(
	array('label'=>'List User', 'url'=>array('index')),
	array('label'=>'Manage User', 'url'=>array('admin')),
);*/
?>

<h1>Create Tenant</h1>

<?php echo $this->renderPartial('_create_tanent', array('model'=>$model)); ?>
