<?php

class SiteController extends Controller
{

    public function filters()
    {
        // return the filter configuration for this controller, e.g.:
        return array(
            'checkout + checkout',
        );
    }

    public function filterCheckout($filterChain)
    {
        if (!isset($_REQUEST['id'])) {
            $this->redirect(array("site/index"));
        } else {
            $model = Service::model()->findbyPk($_REQUEST['id']);
            if ($model == null)
                $this->redirect(array("site/index"));
        }

        $filterChain->run();
    }

    /**
     * Declares class-based actions.
     */
    public function actions()
    {
        return array(
            // captcha action renders the CAPTCHA image displayed on the contact page
            'captcha' => array(
                'class' => 'CCaptchaAction',
                'backColor' => 0xFFFFFF,
            ),
            // page action renders "static" pages stored under 'protected/views/site/pages'
            // They can be accessed via: index.php?r=site/page&view=FileName
            'page' => array(
                'class' => 'CViewAction',
            ),
        );
    }

    /**
     * This is the default 'index' action that is invoked
     * when an action is not explicitly requested by users.
     */
    public function actionIndex($id = 8)
    {
        Yii::app()->controller->uid = $id;
        // renders the view file 'protected/views/site/index.php'
        // using the default layout 'protected/views/layouts/main.php'
        //if(Yii::app()->user->isGuest)
        $this->render('index', array('id' => $id));
        //else
        // $this->render('dashboard');
    }

    public function actionCheckout($id)
    {

        $item = Service::model()->front()->findbyPk($id);

        if ($item == null || !($item->qty - $item->qty_ordered))
            throw new CHttpException(404, 'The requested page does not exist.');
        Yii::app()->controller->uid = $item->t_id;
        $model = new Order;


        if (isset($_POST['Order'])) {
            $model->attributes = $_POST['Order'];
            if ($model->validate()) {
                $model->date = date('Y-m-d H:i:s', time());
                $model->sv_id = $item->id;
                $model->service_price = $item->price;
                $model->service_name = $item->name;
                $model->service_description = $item->description;
                $model->save(false);

                Yii::import('application.extensions.phpMailer.yiiPhpMailer');
                $provider = Tenant::model()->find('id=?', array($item->t_id));

                //var_dump($model->email, $provider->email); die();
                $str1 = $this->renderPartial('//templates/order', array('model' => $model, 'provider_name' => $provider->name,), true);

                $str2 = $this->renderPartial('//templates/order2', array(
                    'model' => $model,
                    'provider_name' => $provider->name,
                        ), true);
                $subject = "Order Confirmation";

                $mailer = new yiiPhpMailer;
                $mailer->Ready($subject, $str1, array('email' => $model->email, 'name' => $model->email));
                $mailer->Ready($subject, $str2, array('email' => $provider->email, 'name' => $provider->email));
                //$this->redirect('http://paypal.com');
                $this->redirect(array("site/orderConfirm", 'id' => $item->t_id));
            }
        }


        $this->render('checkout', array('item' => $item, 'model' => $model));
    }

    public function actionOrderConfirm($id)
    {
        $url = $this->createUrl('/' . $id);
        header("refresh: 5; " . $url);
        $this->render("order_confirm", array(
            'url' => $url,
        ));
    }

    /**
     * This is the action to handle external exceptions.
     */
    public function actionError()
    {
        if ($error = Yii::app()->errorHandler->error) {
            if (Yii::app()->request->isAjaxRequest)
                echo $error['message'];
            else
                $this->render('error', $error);
        }
    }

    /**
     * Displays the contact page
     */
    public function actionContact()
    {
        $model = new ContactForm;
        if (isset($_POST['ContactForm'])) {
            $model->attributes = $_POST['ContactForm'];
            if ($model->validate()) {
                $headers = "From: {$model->email}\r\nReply-To: {$model->email}";
                mail(Yii::app()->params['adminEmail'], $model->subject, $model->body, $headers);
                Yii::app()->user->setFlash('contact', 'Thank you for contacting us. We will respond to you as soon as possible.');
                $this->refresh();
            }
        }
        $this->render('contact', array('model' => $model));
    }

    /**
     * Displays the login page
     */
    public function actionLogin()
    {
        $this->layout = "admin_login";
        $model = new LoginForm;

        // if it is ajax validation request
        if (isset($_POST['ajax']) && $_POST['ajax'] === 'login-form') {
            echo CActiveForm::validate($cmodel);
            Yii::app()->end();
        }

        // collect user input data
        if (isset($_POST['LoginForm'])) {
            $model->attributes = $_POST['LoginForm'];
            // validate user input and redirect to the previous page if valid
            if ($model->validate() && $model->login())
                $this->redirect(array('admin/default/index'));
        }
        // display the login form
        $this->render('login', array('model' => $model));
    }

    /**
     * Logs out the current user and redirect to homepage.
     */
    public function actionLogout()
    {
        Yii::app()->user->logout();
        $this->redirect(array("site/login"));
    }

    /**
     * Added 12.04.2012
     * */
    public function actionRegister()
    {
        $register = new RegisterForm;


        if (isset($_POST['ajax']) && $_POST['ajax'] === 'register-form') {
            echo CActiveForm::validate($register);
            Yii::app()->end();
        }

        if (isset($_POST['RegisterForm'])) {
            $register->attributes = $_POST['RegisterForm'];
            if ($register->validate()) {
                //echo "validated";
                //exit;
                $user = $register->save($register);
                //  echo "okkkk";
                // exit;
                if (!is_object($user)) {
                    //   echo "ok1";
                    // exit;
                    $register->addError(null, $user);
                } else {
                    //echo "ok2";
                    //exit;
                    $str = $this->renderPartial('//templates/confirm', array(
                        'VerifyKey' => $user->confirm_key . $user->id
                            ), true);

                    $subject = "Activate your account";

                    Yii::import('application.extensions.phpMailer.yiiPhpMailer');
                    $mailer = new yiiPhpMailer;
                    $mailer->Ready($subject, $str, array('name' => $user->username, 'email' => $user->email));

                    Yii::app()->user->setFlash('success', "Please, check your email...");
                    $this->redirect(array('site/login'));
                }
            }
        }
        $this->render('register', array(
            'model' => $register
        ));
    }

    /**
     * Added 12.04.2012
     * */
    public function actionConfirm($k = null)
    {
        $model = new ConfirmForm;

        if ($k != null) {
            $supossedUserId = substr($k, 32, strlen($k));
            $model->confirmvalue = substr($k, 0, 32);

            if ($model->validate()) {
                $user = Tenant::model()->find(array(
                    'condition' => 't.id = :id AND t.confirm_key = :confirm_key',
                    'params' => array(
                        ':id' => $supossedUserId,
                        ':confirm_key' => $model->confirmvalue
                    ),
                        ));

                if ($user === null)
                    $model->addError('', 'Invalid verification code');
                else {
                    if ($user->isactive != 1) {
                        $user->isactive = 1;
                        $user->save(false);

                        $str = $this->renderPartial('//templates/welcome', array(), true);

                        $subject = "Welcome to CalendarCart";

                        Yii::import('application.extensions.phpMailer.yiiPhpMailer');
                        $mailer = new yiiPhpMailer;
                        $mailer->Ready($subject, $str, array('name' => $user->username, 'email' => $user->email));

                        Yii::app()->user->setFlash('AuthController_confirm', "User verified, now you can login...");
                    }
                }
            }
        }
        Yii::app()->request->redirect(Yii::app()->createAbsoluteUrl('site/login'));
    }

    /**
     * Added 13.04.2012
     */
    public function actionRecover()
    {
        $recover = new RecoverForm;
        if (isset($_POST['RecoverForm'])) {
            $recover->attributes = $_POST['RecoverForm'];
            if ($recover->validate()) {
                $user = Tenant::model()->findByEmail($recover->email);
                if ($user === null)
                    Yii::app()->user->setFlash('errorMessage', "Well! We can't find you. Please, try again.");
                else {
                    $user->confirm_key = md5($user->username . date("dmyGis"));
                    $user->save(false);

                    $str = $this->renderPartial('//templates/recover', array(
                        'VerifyKey' => $user->confirm_key . $user->id
                            ), true);

                    $subject = "Reset your password";

                    Yii::import('application.extensions.phpMailer.yiiPhpMailer');
                    $mailer = new yiiPhpMailer;
                    $mailer->Ready($subject, $str, array('name' => $user->username, 'email' => $user->email));

                    Yii::app()->user->setFlash('success', "Password reset instructions was sent by email...");
                    $this->redirect(Yii::app()->createUrl('site/login'));
                }
            }
        }

        $this->render('recover', array(
            'model' => $recover
        ));
    }

    public function actionRecoverName()
    {
        $recover = new RecoverNameForm;
        if (isset($_POST['RecoverNameForm'])) {
            $recover->attributes = $_POST['RecoverNameForm'];
            if ($recover->validate()) {
                $user = Tenant::model()->findByEmail($recover->email);
                if ($user === null)
                    Yii::app()->user->setFlash('errorMessage', "Well! We can't find you. Please, try again.");
                else {
                    $user->confirm_key = md5($user->username . date("dmyGis"));
                    $user->save(false);

                    $str = $this->renderPartial('//templates/recover_name', array(
                        'name' => $user->username
                            ), true);

                    $subject = "Get your username";

                    Yii::import('application.extensions.phpMailer.yiiPhpMailer');
                    $mailer = new yiiPhpMailer;
                    $mailer->Ready($subject, $str, array('name' => $user->username, 'email' => $user->email));

                    Yii::app()->user->setFlash('success', "Username was sent by email...");
                    $this->redirect(Yii::app()->createUrl('site/login'));
                }
            }
        }

        $this->render('recover_name', array(
            'model' => $recover
        ));
    }

    public function actionOrder2()
    {
        $model = Order::model()->find('id=13');

        $provider = Tenant::model()->find('id=8');
        $this->renderPartial('//templates/order', array(
            'model' => $model,
            'provider_name' => $provider->name,
        ));
    }

    public function actionloadImage($id)
    {
        $model = Tenant::model()->findbyPk($id);
        $this->renderPartial('image', array(
            'model' => $model
        ));
    }

}
