<?php $this->beginContent('//layouts/main'); ?>
<div class="row">
	<div class="span9">
			<?php echo $content; ?>
	</div>
	<div class="span3">
		<div class="well sidebar-nav">
			<?php
				/* $this->beginWidget('zii.widgets.CPortlet', array(
					'title'=>'Operations',
				));
				$this->widget('bootstrap.widgets.TbMenu', array(
					'type'=>'list',
					'items'=>$this->menu
				));
				$this->endWidget(); */
			?>
			<?php
				$this->beginWidget('zii.widgets.CPortlet', array(
					'title'=>'Usefull Links',
					'titleCssClass'=>'portletTitle',
				));
				$this->widget('bootstrap.widgets.TbMenu', array(
					'type'=>'list',
					'items'=>array(
						array('label'=>'Help', 'url'=>array('#myModal'), 'linkOptions'=>array('data-toggle'=>'modal')),
					),
				));
				$this->endWidget();
			?>
		</div>
	</div>
</div>

<?php $this->endContent(); ?>

