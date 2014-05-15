<?php

class AccountController extends Controller
{
	public function filters()
	{
		return array(
			'accessControl',
		);
	}
	
	public function accessRules()
	{
		return array(
			array('allow',  // allow all users to perform 'index' and 'view' actions
				'actions'=>array('restore','ChangePassword'),
				'users'=>array('*'),
			),
			array('deny',  // deny all users
				'users'=>array('*'),
			),
		);
	}
	
	public function actionRestore()
	{
		$k = Yii::app()->request->getParam("k", null);
		$model = new ConfirmForm;
		
		if ($k != null)
		{
			$supossedUserId = substr($k, 32, strlen($k));
			$model->confirmvalue = substr($k, 0, 32);
			
			if ($model->validate())
				$this->redirect(Yii::app()->createUrl('account/changepassword', array('uid'=>$model->confirmvalue, 'hash'=>md5($supossedUserId))));
		}
		
		throw new CHttpException(400,'Invalid request. Please do not repeat this request again.');
	}
	
	public function actionChangePassword($uid)
	{
		$model = new RestoreForm();
		if(isset($_POST['RestoreForm']))
		{
			$model->attributes = $_POST['RestoreForm'];
			if($model->validate())
			{
				$user = User::model()->find(array(
					'condition'=>'t.confirm_key = :confirm_key',
					'params'=>array(
						':confirm_key'=>$uid
					),
				));
				
				if($user===null)
					$model->addError('', 'Invalid verification code');
				else
				{
					$user->password = md5($model->password);
					$user->save(false);
					Yii::app()->user->setFlash('success',"Your password has been updated...");
					$this->redirect(Yii::app()->createUrl('site/login'));
				}
			}
		}
		$this->render('restore', array(
			'model'=>$model
		));
	}
}