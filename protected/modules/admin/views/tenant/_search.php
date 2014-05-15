<?php
$form = $this->beginWidget('bootstrap.widgets.TbActiveForm', array(
	'id'=>'search-tenant-form',
	'enableAjaxValidation'=>false,
	'action'=>Yii::app()->createUrl($this->route),
	'method'=>'post',
	'htmlOptions'=>array(
		'class'=>'well form-search',
		'type'=>'horizontal',
	),
)); ?>

	<div class="control-group">
		<?php echo CHtml::label('Date between', CHtml::activeId($model, 'creation_date'), array('class'=>'span2')); ?>
		<?php echo $form->textField($model,'creation_date', array('class'=>'span2')); ?>
		
		<?php echo CHtml::label('End Date', CHtml::activeId($model, 'endDate')); ?>
		<?php echo $form->textField($model,'endDate', array('class'=>'span2')); ?>
	</div>
	
	<div style="text-align:right">
		<?php $this->widget('bootstrap.widgets.TbButton', array('buttonType'=>'submit', 'type'=>'primary', 'icon'=>'search white', 'label'=>'Search')); ?>
		<?php $this->widget('bootstrap.widgets.TbButton', array('buttonType'=>'button', 'icon'=>'icon-remove-sign white', 'label'=>'Reset', 'htmlOptions'=>array('class'=>'btnreset btn-small'))); ?>
	</div>

<?php $this->endWidget(); ?>

<?php
$cs = Yii::app()->getClientScript();
$cs->registerCoreScript('jquery');
$cs->registerCoreScript('jquery.ui');
$cs->registerCssFile(Yii::app()->request->baseUrl.'/css/bootstrap/jquery-ui.css');
$cs->registerScript('jquery.datepicker','	
var dates = $( "#'.CHtml::activeId($model, 'creation_date').', #'.CHtml::activeId($model, 'endDate').'" ).datepicker({
		changeMonth: true,
		onSelect: function( selectedDate ) {
			var option = this.id == "'.CHtml::activeId($model, 'creation_date').'" ? "minDate" : "maxDate",
				instance = $( this ).data( "datepicker" ),
				date = $.datepicker.parseDate(
					instance.settings.dateFormat ||
					$.datepicker._defaults.dateFormat,
					selectedDate, instance.settings );
			dates.not( this ).datepicker( "option", option, date );
		}
	});
	
	$(".btnreset").click(function(){
		$(":input","#search-tenant-form").each(function() {
		var type = this.type;
		var tag = this.tagName.toLowerCase(); // normalize case
		if (type == "text" || type == "password" || tag == "textarea") this.value = "";
		else if (type == "checkbox" || type == "radio") this.checked = false;
		else if (tag == "select") this.selectedIndex = "";
	  });
	});
');
?>
