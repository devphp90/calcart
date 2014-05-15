<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en">
<head>
<title>Please Confirm your email address</title>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<meta content="width=device-width; initial-scale=1.0; maximum-scale=1.0; user-scalable=0;" name="viewport" />
</head>
<body style="margin: 0; padding: 20px;">
    	
        <h1 class="headline" style="font-weight: normal; padding-top: 12px; min-height: 34px; font: 20px/20px HelveticaNeue-Light, 'Helvetica Neue Light', sans-serif;">
        	Thank you for joining CalendarCart
        </h1>
		<p>
			Please confirm your email by <?php echo CHtml::link('clicking here', Yii::app()->createAbsoluteUrl('site/confirm', array('k'=>$VerifyKey)));?>.
		</p>
		<p>
			Alternatively, paste <?php echo CHtml::link(Yii::app()->createAbsoluteUrl('site/confirm', array('k'=>$VerifyKey)), Yii::app()->createAbsoluteUrl('site/confirm', array('k'=>$VerifyKey)));?> into your browser address window to confirm that this is your email address.
		</p>
        <p>
        	Regards,<br />
			CalendarCart Team<br />
			<hr />
			This message was created by CalendarCart
        </p>
	</div>
</body>
</html>