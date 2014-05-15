<?php

/**
 * UserIdentity represents the data needed to identity a user.
 * It contains the authentication method that checks if the provided
 * data can identity the user.
 */
class UserIdentity extends CUserIdentity
{
	private $_id;

	const ERROR_USER_INACTIVE = 101;

	/**
	 * Authenticates a user.
	 * The example implementation makes sure if the username and password
	 * are both 'demo'.
	 * In practical applications, this should be changed to authenticate
	 * against some persistent user identity storage (e.g. database).
	 * @return boolean whether authentication succeeds.
	 */
	public function authenticate()
	{
		$criteria = new CDbCriteria();
		$criteria->condition = 'LOWER(username) = :username';
		$criteria->params = array(
			':username'=>strtolower($this->username),
		);


		$users = Tenant::model()->find($criteria);


		if($users === null)
			$this->errorCode=self::ERROR_USERNAME_INVALID;
		else if($users->password != md5($this->password))
			{
				//echo "Wrong password:(you entered:".md5($this->password)."<br/>we have:".$users->password.")";
				//exit;
				$this->errorCode=self::ERROR_PASSWORD_INVALID;
			}
		else if($users->isactive == false)
				$this->errorCode=self::ERROR_USER_INACTIVE;
			else
			{
				$this->errorCode=self::ERROR_NONE;
				$this->_id = $users->id;
				//die(var_dump($this->_id));
			}

		return !$this->errorCode;
	}

	public function getId()
	{
		return (int)$this->_id;
	}
}
