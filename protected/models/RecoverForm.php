<?php

/**
 * RecoverForm class.
 * RecoverForm is the data structure for keeping
 * user login form data. It is used by the 'login' action of 'SiteController'.
 */
class RecoverForm extends CFormModel
{
	public $email;
	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('email', 'required'),
			array('email', 'email'),
			array('email', 'length', 'max'=>45),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'email' => 'Email',
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