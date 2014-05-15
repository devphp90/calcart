<?php
class ValidateUser extends CWebUser
{
	public function getIsAdmin()
	{
		if(Yii::app()->user->isGuest)
			return false;
		else
			return (bool)Tenant::model()->findByPk(Yii::app()->user->id)->isadmin;
	}
}
?>
