<?php

class DefaultController extends Controller
{
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

            array('allow',
                'users'=>array('@'),
            ),
            array('deny',  // deny all users
                'users'=>array('*'),
            ),
        );
    }
	
	public function actionIndex()
	{
		$tenant = Tenant::model()->findByPk(Yii::app()->user->id);
		//$this->redirect(array("service/index"));
		$this->render('index',array(
			'model'=>$tenant,
		));
	}

	public function actionHelp()
	{
		$this->render("help");
	}

}
