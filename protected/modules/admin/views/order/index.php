<?php
$this->breadcrumbs = array(
    'Orders',
);

$this->menu = array(
    array('label' => 'Create Order', 'url' => array('create')),
);

Yii::app()->clientScript->registerScript('search', "
$('.search-button').click(function(){
    $('.search-form').slideToggle('fast');
    return false;
});
$('.search-form form').submit(function(){
    $.fn.yiiGridView.update('order-grid', {
        data: $(this).serialize()
    });
    return false;
});
");
?>

<h1>Orders</h1>
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
        array('label' => 'Create', 'icon' => 'icon-plus', 'url' => Yii::app()->controller->createUrl('create'), 'linkOptions' => array()),
//        array('label' => 'List', 'icon' => 'icon-th-list', 'url' => Yii::app()->controller->createUrl('index'), 'linkOptions' => array()),
        array('label' => 'Search', 'icon' => 'icon-search', 'url' => '#', 'linkOptions' => array('class' => 'search-button')),
        array('label' => 'Export to PDF', 'icon' => 'icon-download', 'url' => Yii::app()->controller->createUrl('GeneratePdf'), 'linkOptions' => array('target'=>'_blank','title'=>'Coming soon', 'onclick' => 'return false'), 'visible' => true),
        array('label' => 'Export to Excel', 'icon' => 'icon-download', 'url' => Yii::app()->controller->createUrl('GenerateExcel'), 'linkOptions' => array('target'=>'_blank','title'=>'Coming soon', 'onclick' => 'return false'), 'visible' => true),
//        array('label' => 'Print', 'icon' => 'icon-print', 'url' => array('print'), 'linkOptions' => array('class' => 'jprint')),
        array('label' => 'Help', 'icon' => 'icon-question-sign', 'url' => array('#myModal'), 'linkOptions' => array('data-toggle' => 'modal'))
    ),
));
$this->endWidget();
?>
<div class="search-form" style="display:none">
    <?php
    $this->renderPartial('_search', array(
        'model' => $model,
    ));
    ?>
</div>
<?php
$this->widget('bootstrap.widgets.TbGridView', array(
    'type' => 'striped bordered condensed',
    'id' => 'order-grid',
    'dataProvider' => $model->search(),
    'template'=>"{items}\n{pager}",
    'columns' => array(
        array(
            'name' => 'date',
            'type' => 'raw',
            'value' => 'CHtml::link(Yii::app()->dateFormatter->format("MMM dd, yyyy", $data->date), Yii::app()->controller->createUrl("view", array("id"=>$data->id)))',
            'htmlOptions' => array('width' => '80'),
        ),
        'service_name',
        'service_description',
        array(
            'name' => 'service_price',
            'value' => 'Yii::app()->NumberFormatter->formatCurrency(CHtml::encode($data->service_price), \'USD\')',
        ),
        array(
            'name' => 'first_name',
            'type' => 'html',
            'value' => '$data->first_name'
        ),
        array(
            'name' => 'last_name',
            'type' => 'html',
            'value' => '$data->last_name'
        ),
        'phone',
        'email',
        array(
            'class' => 'bootstrap.widgets.TbButtonColumn',
            'template' => '{update} {delete}',
            'buttons' => array(
                'update' => array(
                    'label' => 'Update',
                    'options' => array(
                        'class' => 'btn btn-small update'
                    )
                ),
                'delete' => array(
                    'label' => 'Delete',
                    'options' => array(
                        'class' => 'btn btn-small delete'
                    )
                )
            ),
            'htmlOptions' => array('style' => 'width: 80px'),
        )
    ),
));
?>
