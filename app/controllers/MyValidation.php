<?php
use Phalcon\Validation;
use Phalcon\Validation\Validator\Email;
use Phalcon\Validation\Validator\PresenceOf;
use Phalcon\Validation\Validator\Regex;

class MyValidation extends Phalcon\Validation
{
	public function initialize()
	{
		$this->add('name', new PresenceOf(array(
			'message' => 'The name is required'
		)));

		$this->add('email', new PresenceOf(array(
			'message' => 'The e-mail is required'
		)));
		$this->add('email', new Email(array(
			'message' => 'The e-mail is not valid'
		)));
//		$this->add('password', new PresenceOf(array(
//			'message' => 'The password is required'
//		)));
//		$this->add('password', new Confirmation(array(
//			'message' => 'Password doesn\'t match confirmation',
//			'with' => 'confirmPassword'
//		)));
		$this->add('phone', new Regex(array(
			'message' => 'The telephone is required',
			'pattern' => '/\(?([0-9]{4})\)?([ .-]?)([0-9]{3})\2([0-9]{4})/'
		)));
		$this->add('fullname', new PresenceOf(array(
			'message' => 'The fullname is required'
		)));
	}
}


