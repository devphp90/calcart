<?php

/**
 * RestoreForm class.
 * RestoreForm is the data structure for keeping
 * user login form data. It is used by the 'login' action of 'SiteController'.
 */
class RestoreForm extends CFormModel
{
	public $password;
	public $confirmpassword;
	
	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('password, confirmpassword', 'required'),
			array('password, confirmpassword', 'length', 'max'=>32),
			array('password', 'compare', 'compareAttribute' => 'confirmpassword'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'password' => 'New Password',
			'confirmpassword' => 'Re-type new password',
		);
	}
	
	public function verify($email)
	{
		if(!$this->hasErrors())
		{
			//
		}
		
		return false;
	}
}