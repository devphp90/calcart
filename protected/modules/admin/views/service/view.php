<?php
$this->breadcrumbs = array(
    'Services' => array('index'),
    'Service ID #' . $model->id,
);

$this->menu = array(
    array('label' => 'List Services', 'url' => array('index')),
    array('label' => 'Create Service', 'url' => array('create')),
    array('label' => 'Update Service', 'url' => array('update', 'id' => $model->id)),
    array('label' => 'Delete Service', 'url' => '#', 'linkOptions' => array('submit' => array('delete', 'id' => $model->id), 'confirm' => 'Are you sure you want to delete this item?')),
);
?>

<h1>Service Detail</h1>
<hr />
<?php
$this->beginWidget('zii.widgets.CPortlet', array(
    'htmlOptions' => array(
        'class' => ''
    )
));
$this->widget('bootstrap.widgets.TbMenu', array(
    'type' => 'pills',
    'items' => array(
        array('label' => 'Create', 'icon' => 'icon-plus', 'url' => Yii::app()->controller->createUrl('create')),
        array('label' => 'List', 'icon' => 'icon-th-list', 'url' => Yii::app()->controller->createUrl('index'), 'linkOptions' => array()),
        array('label' => 'Update', 'icon' => 'icon-edit', 'url' => Yii::app()->controller->createUrl('update', array('id' => $model->id))),
        array('label' => 'Print', 'icon' => 'icon-print', 'url' => array('print'), 'linkOptions' => array('class' => 'jprint')),
        array('label' => 'Help', 'icon' => 'icon-question-sign', 'url' => 'javascript:void(0)', 'linkOptions' => array())
    ),
));
$this->endWidget();
?>
<?php
$this->widget('bootstrap.widgets.TbDetailView', array(
    'data' => $model,
    'attributes' => array(
        'id',
        array(
            'name' => 'date',
            'type' => 'raw',
            'value' => Yii::app()->dateFormatter->format("MMM dd, yyyy", $model->date)
        ),
        array(
            'name' => 'name',
            'type' => 'html',
            'value' => $model->name
        ),
        array(
            'name' => 'description',
            'type' => 'html',
            'value' => $model->description
        ),
        array(
            'name' => 'qty',
            'type' => 'html',
            'value' => $model->qty
        ),
        'qty_ordered',
        array(
            'name' => 'price',
            'type' => 'raw',
            'value' => Yii::app()->NumberFormatter->formatCurrency(CHtml::encode($model->price), 'USD'),
            'htmlOptions' => array(
                'style' => 'text-align:right'
            )
        ),
        array(
            'name' => 'active',
            'value' => $model->active != 1 ? 'inactive' : 'active',
        ),
        array(
            'label' => 'image',
            'type' => 'html',
            'value' => '<div class="scale-down">' . CHtml::image(Utils::uploadUrl('/image/service/' . $model->image)) . '</div>',
            'visible' => (!empty($model->image)) ? true : false,
        )
    ),
));
?>
