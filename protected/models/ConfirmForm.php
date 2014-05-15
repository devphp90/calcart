<?php
class ConfirmForm extends CFormModel
{
	public $confirmvalue;
	
	/**
	 * Declares the validation rules.
	 */
	public function rules()
	{
		return array(
			array('confirmvalue', 'required')
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
			'confirmvalue' => 'Confirmation Key',
		);
	}
}