<?php

namespace ZfcUser\Form;

use Zend\Form\Element\Captcha as Captcha;
use ZfcUser\Options\RegistrationOptionsInterface;

class Register extends Base
{
	protected $captchaElement= null;

	/**
	 * @var RegistrationOptionsInterface
	 */
	protected $registrationOptions;

	/**
	 * @param string|null $name
	 * @param RegistrationOptionsInterface $options
	 */
	public function __construct($name = null, RegistrationOptionsInterface $options)
	{
		$this->setRegistrationOptions($options);
		parent::__construct($name);

		$this->remove('userId');
		if (!$this->getRegistrationOptions()->getEnableUsername()) {
			$this->remove('username');
		}
		if (!$this->getRegistrationOptions()->getEnableDisplayName()) {
			$this->remove('display_name');
		}
		if ($this->getRegistrationOptions()->getUseRegistrationFormCaptcha() && $this->captchaElement) {
			$this->add($this->captchaElement, array('name'=>'captcha'));
		}

		$arElement = new \Zend\Form\Element\Checkbox('ar');
		$arElement
			->setLabel('Zapoznałem się z <a href="/zasady/regulamin" target="_blank">regulaminen</a> i akceptuję go.')
			->setAttributes(array(
				'id' => 'ar',
				'type'  => 'checkbox',
				'required' => true
		));
		$this->add($arElement);

		$apElement = new \Zend\Form\Element\Checkbox('ap');
		$apElement
			->setLabel('Zapoznałem się z <a href="/zasady/polityka-prywatnosci" target="_blank">polityką prywatności</a> i akceptuję ją.')
			->setAttributes(array(
				'id' => 'ap',
				'type'  => 'checkbox',
				'required' => true
		));
		$this->add($apElement);

		$this->get('submit')->setLabel('zarejestruj się');
		$this->getEventManager()->trigger('init', $this);
	}

	public function setCaptchaElement(Captcha $captchaElement)
	{
		$this->captchaElement= $captchaElement;
	}

	/**
	 * Set Regsitration Options
	 *
	 * @param RegistrationOptionsInterface $registrationOptions
	 * @return Register
	 */
	public function setRegistrationOptions(RegistrationOptionsInterface $registrationOptions)
	{
		$this->registrationOptions = $registrationOptions;
		return $this;
	}

	/**
	 * Get Regsitration Options
	 *
	 * @return RegistrationOptionsInterface
	 */
	public function getRegistrationOptions()
	{
		return $this->registrationOptions;
	}
}
