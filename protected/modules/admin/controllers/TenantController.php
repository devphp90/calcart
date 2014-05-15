<?php

class TenantController extends Controller
{
	/**
	 * @var string the default layout for the views. Defaults to '//layouts/column2', meaning
	 * using two-column layout. See 'protected/views/layouts/column2.php'.
	 */
	//public $layout='//layouts/column1';
	public $layout='main';

	/**
	 * @return array action filters
	 */
	public function filters()
	{
		return array(
			'accessControl', // perform access control for CRUD operations
		);
	}

	/**
	 * Specifies the access control rules.
	 * This method is used by the 'accessControl' filter.
	 * @return array access control rules
	 */
	public function accessRules()
	{
		return array(
			array('allow',  // allow all users to perform 'index' and 'view' actions
				'actions'=>array('view'),
				'users'=>array('*'),
			),
			array('allow', // allow authenticated user to perform 'create' and 'update' actions
				'actions'=>array('update','loadImage'),
				//'expression'=>'!$user->isGuest && (Yii::app()->request->getParam("id",0) == Yii::app()->user->id)',
				'users'=>array('@'),
			),
			array(
				'allow',
				'actions'=>array('index','update','view','create','delete'),
				'expression'=>'Yii::app()->user->isAdmin',
			),
			/*array('allow', // allow authenticated user to perform 'create' and 'update' actions
				'actions'=>array('create','update'),
				'users'=>array('@'),
			),
			array('allow', // allow admin user to perform 'admin' and 'delete' actions
				'actions'=>array('admin','delete'),
				'users'=>array('admin'),
			),*/
			array('deny',  // deny all users
				'users'=>array('*'),
			),
		);
	}

	/**
	 * Displays a particular model.
	 * @param integer $id the ID of the model to be displayed
	 */
	public function actionView($id)
	{
		$this->render('view',array(
				'model'=>$this->loadModel($id),
			));
	}

	/**
	 * Creates a new model.
	 * If creation is successful, the browser will be redirected to the 'view' page.
	 */
	public function actionCreate()
	{
		$model=new Tenant;
		$model->setScenario('create');
		if(isset($_POST['Tenant']))
		{
			$model->attributes=$_POST['Tenant'];
			if(!empty($_FILES['Tenant']['tmp_name']['avatarfile']))
			{
				$file = CUploadedFile::getInstance($model,'avatarfile');
				$model->avatarfileName = $file->name;
				$model->avatarfileType = $file->type;

				$fp = fopen($file->tempName, 'r');
				$content = fread($fp, filesize($file->tempName));
				fclose($fp);
				$model->avatarfile = $content;
			}
			$model->last_update=date('Y-m-d H:i:s',time());
			if($model->validate())
			{
				$model->confirm_key = md5($model->username.date("dmyGis"));
				$model->save(false);

				$str = $this->renderPartial('//templates/confirm',array(
						'VerifyKey' => $model->confirm_key.$model->id
					),true);

				$subject = "Activate your account";

				Yii::import('application.extensions.phpMailer.yiiPhpMailer');
				$mailer = new yiiPhpMailer;
				$mailer->Ready($subject, $str, array('name'=>$model->username,'email'=>$model->email));


				$this->redirect(array('view','id'=>$model->id));
			}
		}

		$this->render('create',array(
				'model'=>$model,
			));
	}

	/**
	 * Updates a particular model.
	 * If update is successful, the browser will be redirected to the 'view' page.
	 * @param integer $id the ID of the model to be updated
	 */
	public function actionUpdate($id)
	{
		$model=$this->loadModel($id);
		unset($model->password);
		// Uncomment the following line if AJAX validation is needed
		// $this->performAjaxValidation($model);

		if(isset($_POST['Tenant']))
		{
			$model->attributes=$_POST['Tenant'];
			
			if(!empty($_FILES['Tenant']['tmp_name']['avatarfile']))
			{
				$file = CUploadedFile::getInstance($model,'avatarfile');
				$model->avatarfileName = $file->name;
				$model->avatarfileType = $file->type;

				$fp = fopen($file->tempName, 'r');
				$content = fread($fp, filesize($file->tempName));
				fclose($fp);
				$model->avatarfile = $content;
			}else
				unset($model->avatarfile);
			$model->last_update=date('Y-m-d H:i:s',time());
			if($model->save())
				$this->redirect(array('view','id'=>$model->id));
		}

		$this->render('update',array(
				'model'=>$model,
			));
	}

	/**
	 * Deletes a particular model.
	 * If deletion is successful, the browser will be redirected to the 'admin' page.
	 * @param integer $id the ID of the model to be deleted
	 */
	public function actionDelete($id)
	{
		if(Yii::app()->request->isPostRequest)
		{
			// we only allow deletion via POST request
			$this->loadModel($id)->delete();

			// if AJAX request (triggered by deletion via admin grid view), we should not redirect the browser
			if(!isset($_GET['ajax']))
				$this->redirect(isset($_POST['returnUrl']) ? $_POST['returnUrl'] : array('admin'));
		}
		else
			throw new CHttpException(400,'Invalid request. Please do not repeat this request again.');
	}

	/**
	 * Lists all models.
	 */
	public function actionIndex()
	{
		//$this->actionView(Yii::app()->user->id);
		$model=new Tenant('search');
		$model->unsetAttributes();  // clear any default values

		//$totalAmount = 0;

		if(isset($_GET['Tenant']))
		{
			$model->attributes=$_GET['Tenant'];

			$criteria = new CDbCriteria();

			if (!empty($model->creation_date)) $criteria->addCondition('date >= "'.Yii::app()->dateFormatter->format('yyyy-MM-dd 00:00:01', $model->creation_date).'"');
			if (!empty($model->endDate)) $criteria->addCondition('date <= "'.Yii::app()->dateFormatter->format('yyyy-MM-dd 23:59:59', $model->endDate).'"');
			/*
			$criteria->params = array(
				':user_id'=>Yii::app()->user->id
			);
			 */

		}
		else {

		}

		$this->render('index',array(
				'model'=>$model,
			));
	}

	/**
	 * Returns the data model based on the primary key given in the GET variable.
	 * If the data model is not found, an HTTP exception will be raised.
	 * @param integer the ID of the model to be loaded
	 */
	public function loadModel($id)
	{
		$model=Tenant::model()->findByPk($id);
		if($model===null)
			throw new CHttpException(404,'The requested page does not exist.');
		if(!Yii::app()->user->isAdmin){
			if($id != Yii::app()->user->id)
				throw new CHttpException(404,'The requested page does not exist.');			
		}
		return $model;
	}

	/**
	 * Performs the AJAX validation.
	 * @param CModel the model to be validated
	 */
	protected function performAjaxValidation($model)
	{
		if(isset($_POST['ajax']) && $_POST['ajax']==='user-form')
		{
			echo CActiveForm::validate($model);
			Yii::app()->end();
		}
	}
	public function actionloadImage($id)
	{
		$model=Tenant::model()->findbyPk($id);
		$this->renderPartial('image', array(
				'model'=>$model
			));
	}
}
