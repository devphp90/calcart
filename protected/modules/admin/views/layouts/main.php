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
<link rel="stylesheet" href="/css/font-awesome.min.css">

	
	<style type="text/css" media="print">
body {visibility:hidden;}
.printableArea{visibility:visible;}
</style>
</head>
<body>
<script type="text/javascript">
function printDiv()
{
console.log('admin-layout-main');
window.print();

}
</script>
		<?php $this->widget('bootstrap.widgets.TbNavbar', array(
		//'fixed'=>false,
		'brand'=>'AXEO CalCart Admin',
		'brandUrl'=>Yii::app()->createUrl('/admin/default/index'),
		'collapse'=>true, // requires bootstrap-responsive.css
		'items'=>array(
			array(
				'class'=>'bootstrap.widgets.TbMenu',
				'items'=>array(
					array('label'=>'Home', 'url'=>array('/admin/default/index')),
					array('label'=>'Service Sessions',  'url'=>array('/admin/service/index'), 'visible'=>!Yii::app()->user->isGuest),
					array('label'=>'Orders',  'url'=>array('/admin/order/index'), 'visible'=>!Yii::app()->user->isGuest),
					array('label'=>'Accounts',  'url'=>array('/admin/tenant/index'), 'visible'=>Yii::app()->user->isAdmin),
					array('label'=>'SignUp', 'url'=>array('/site/register'), 'visible'=>Yii::app()->user->isGuest),
					array('label'=>'Login', 'url'=>array('/site/login'), 'visible'=>Yii::app()->user->isGuest),
				),
			),
			array(
				'class'=>'bootstrap.widgets.TbMenu',
				'htmlOptions'=>array('class'=>'pull-right'),
				'items'=>array(
					//array('label'=>Yii::app()->user->name, 'url'=>array('/admin/tenant/view','id'=>Yii::app()->user->id), 'visible'=>!Yii::app()->user->isGuest),
					array('label'=>'MyCart', 'linkOptions' => array('target' => '_blank'), 'url'=> Yii::app()->createUrl('/site/index', array('id'=>Yii::app()->user->id)), 'visible'=>!Yii::app()->user->isGuest),
					array('label'=>'MyProfile', 'url'=>array('/admin/tenant/view','id'=>Yii::app()->user->id), 'visible'=>!Yii::app()->user->isGuest),
					array('label'=>'Help', 'url'=>array('/admin/default/help'), 'visible'=>!Yii::app()->user->isGuest),
					//array('label'=>'Manage Tenants', 'url'=>array('/admin/tenant/index'), 'visible'=>Yii::app()->user->isAdmin),
					array('label'=> 'Logout ('. Yii::app()->user->name .')', 'url'=>array('/site/logout'), 'visible'=>!Yii::app()->user->isGuest)
				),
			),
		),
	)); ?>

	<div class="container">
		<?php
/*
$this->widget('bootstrap.widgets.TbBreadcrumbs', array(
                       'homeLink'=>CHtml::link('Home', array('/admin/default/help')),
				'links'=>array(
                        'home'=>array('/admin/default/help'),
                        'help'
                       ),
		));*/

/*if(isset($this->breadcrumbs)) {
	$this->widget('bootstrap.widgets.TbBreadcrumbs', array(
			'homeLink'=>CHtml::link('Home', '/admin/default/index'),
			'links'=>$this->breadcrumbs,
		));
}*/
?>
<br><br><br>
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
			ExecutionTime: <?php echo round(Yii::getLogger()->executionTime, 3); ?>
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
