<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8">
	<title><?php echo CHtml::encode($this->pageTitle); ?></title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="">
    <meta name="author" content="">
	<link rel="stylesheet" type="text/css" href="<?php echo Yii::app()->request->baseUrl; ?>/css/print.css" media="print" />
	<link rel="stylesheet" type="text/css" href="<?php echo Yii::app()->request->baseUrl; ?>/css/styles.css" />
    <!--[if lt IE 9]>
    <script src="http://html5shim.googlecode.com/svn/trunk/html5.js"></script>
    <![endif]-->
	<link rel="shortcut icon" href="<?php echo Yii::app()->request->baseUrl; ?>/ico/favicon.ico">
    <link rel="apple-touch-icon-precomposed" sizes="144x144" href=".<?php echo Yii::app()->request->baseUrl; ?>/ico/apple-touch-icon-144-precomposed.png">
    <link rel="apple-touch-icon-precomposed" sizes="114x114" href="<?php echo Yii::app()->request->baseUrl; ?>/ico/apple-touch-icon-114-precomposed.png">
    <link rel="apple-touch-icon-precomposed" sizes="72x72" href="<?php echo Yii::app()->request->baseUrl; ?>/ico/apple-touch-icon-72-precomposed.png">
    <link rel="apple-touch-icon-precomposed" href="<?php echo Yii::app()->request->baseUrl; ?>/ico/apple-touch-icon-57-precomposed.png">
</head>
<body>
		<?php $this->widget('bootstrap.widgets.TbNavbar', array(
			//'fixed'=>false,
			'brand'=>'CalCart Admin',
			'brandUrl'=>'#',
			'collapse'=>true, // requires bootstrap-responsive.css
			'items'=>array(
				array(
					'class'=>'bootstrap.widgets.TbMenu',
					'items'=>array(
						//array('label'=>'Home', 'url'=>array('/site/login')),
						//array('label'=>'About', 'url'=>array('/site/page', 'view'=>'about')),
						//array('label'=>'Help',  'url'=>array('/site/page', 'view'=>'help')),
					//	array('label'=>'SignUp', 'url'=>array('/site/register'), 'visible'=>Yii::app()->user->isGuest),
					//	array('label'=>'Login', 'url'=>array('/site/login'), 'visible'=>Yii::app()->user->isGuest),
					),
				),
				/*array(
					'class'=>'bootstrap.widgets.TbMenu',
					'htmlOptions'=>array('class'=>'pull-right'),
					'items'=>array(
						array('label'=>Yii::app()->user->name, 'url'=>array('/tenant'), 'visible'=>!Yii::app()->user->isGuest),
						array('label'=>'Manage Tenants', 'url'=>array('/admin'), 'visible'=>Yii::app()->user->isAdmin),
						array('label'=>'Logout', 'url'=>array('/site/logout'), 'visible'=>!Yii::app()->user->isGuest)
					),
				),*/
			),
		)); ?>

	<div class="container">
		<?php
                  
		if(isset($this->breadcrumbs)) {

		} 
                 
		?>
		<?php echo $content; ?>
		<?php $this->beginWidget('bootstrap.widgets.TbModal', array('id'=>'myModal')); ?>
			<div class="modal-header">
				<a class="close" data-dismiss="modal">&times;</a>
				<h3>Modal header</h3>
			</div>		 
			<div class="modal-body">
				<p>One fine body...</p>
			</div>		 
			<div class="modal-footer">
				<?php $this->widget('bootstrap.widgets.TbButton', array(
					'type'=>'primary',
					'label'=>'Ok Button',
					'url'=>'#',
					'htmlOptions'=>array('data-dismiss'=>'modal'),
				)); ?>
				<?php $this->widget('bootstrap.widgets.TbButton', array(
					'label'=>'Close',
					'url'=>'#',
					'htmlOptions'=>array('data-dismiss'=>'modal'),
				)); ?>
			</div>		 
		<?php $this->endWidget(); ?>
		<hr />
		<footer>
			Copyright &copy; <?php echo date('Y'); ?> by <?php echo CHtml::link('AXEO Systems', 'http://axeo.com', array('target'=>'_blank', 'rel'=>'friend')); ?>.<br/>
			<?php echo CHtml::link('Terms of Use', array('/site/page', 'view'=>'terms')); ?> | All Rights Reserved.<br/>
		</footer>
	</div>

<?php
$cs = Yii::app()->getClientScript();
$cs->registerCoreScript('jquery');
$cs->registerScript('jquery.dialog','
	$(".jprint").click(function(event){
		event.preventDefault();
		window.print();
		return false;
	});
	
	$(".scale-down").click(function(event){
		var el = $(this).first();
		event.preventDefault();
		/*$("#mydialog").dialog({
			autoOpen: true,
			width: $(window).width() - 50,
			height: $(window).height() - 50,
			draggable: false,
			resizable: false,
			position: ["center", "center"],
			zIndex: 9999
		}).html(el.clone());*/
		$("#mydialog").modal();
		return false;
	});
');
?>
</body>
</html>
