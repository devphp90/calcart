<?php
/**
 * RegisterForm class.
 * RegisterForm is the data structure for keeping
 * Register form data. It is used by the 'register' action of 'SiteController'.
 */
class RegisterForm extends CFormModel
{
	public $username;
	public $password;
	public $email;
	public $verifyCode;
	public $acceptTerms;
	public $repeatPassword;
	public $repeatEmail;

	/**
	 * Declares the validation rules.
	 */
	public function rules()
	{
		return array(
			array('username, password, email, acceptTerms', 'required'),
			array('username, password', 'length', 'max'=>8, 'min'=>5),
			array('repeatPassword','compare','compareAttribute'=>'password'),
			array('email', 'email'),
			array('repeatEmail','compare','compareAttribute'=>'email'),
			array('acceptTerms', 'boolean', 'strict'=>true, 'falseValue'=>1, 'message'=>'Please accept Terms of Use'),
			array('verifyCode', 'captcha', 'allowEmpty'=>!CCaptcha::checkRequirements()),
		);
	}

	/**
	 * Declares customized attribute labels.
	 * If not declared here, an attribute would have a label that is
	 * the same as its name with the first letter in upper case.
	 */
	public function attributeLabels()
	{
		return array(
			'verifyCode'=>'Verification Code',
			'username' => 'Username',
			'password' => 'Password',
			'email' => 'Email',
			'acceptTerms' => 'Accept Terms of Use'
		);
	}

	public function save($object)
	{
		//echo "im here";
		//exit;
		try
		{
			// echo "inside try";
			//exit;
			$user = new Tenant();
			$user->username = $object->username;
			$user->password = $object->password;
			$user->isactive = 0;
			$user->email = $object->email;
			$user->confirm_key = md5($this->username.date("dmyGis"));
			//echo "in1"
			if (!$user->save())
			{
				throw new Exception("This email is already taken, choose another...");
			}
			//echo "all ok";
			//exit;
			return $user;

		}
		catch(Exception $e)
		{
			return $e->getMessage();
		}
	}
}
