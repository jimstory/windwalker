<?php
/**
 * Part of Windwalker project. 
 *
 * @copyright  Copyright (C) 2014 {ORGANIZATION}. All rights reserved.
 * @license    GNU General Public License version 2 or later;
 */

namespace Windwalker\Crypt;

/**
 * The SimplePassword class.
 * 
 * @since  {DEPLOY_VERSION}
 */
class Password
{
	const MD5 = 3;

	const BLOWFISH = 4;

	const SHA256 = 5;

	const SHA512 = 6;

	/**
	 * Property salt.
	 *
	 * @var  string
	 */
	protected $salt;

	/**
	 * Property cost.
	 *
	 * @var  integer
	 */
	protected $cost;

	/**
	 * Constructor.
	 *
	 * @param int    $cost
	 * @param string $salt
	 */
	public function __construct($cost = 10, $salt = null)
	{
		$this->setSalt($salt);
		$this->setCost($cost);
	}

	/**
	 * create
	 *
	 * @param string $password
	 * @param int    $type
	 *
	 * @return  string
	 */
	public function create($password, $type = self::BLOWFISH)
	{
		$salt = $this->salt ? : str_replace('+', '.', base64_encode(CryptHelper::genRandomBytes(64)));

		switch ($type)
		{
			case static::MD5:
				$salt = '$1$' . $salt . '$';
				break;

			case static::SHA256:
				$cost = ($this->cost < 1000) ? 1000 : $this->cost;

				$salt = '$5$rounds=' . $cost . '$' . $salt . '$';
				break;

			case static::SHA512:
				$cost = ($this->cost < 1000) ? 1000 : $this->cost;

				$salt = '$6$rounds=' . $cost . '$' . $salt . '$';
				break;

			default:
			case static::BLOWFISH:
				$prefix = (version_compare(PHP_VERSION, '5.3.7') >= 0) ? '$2y$' : '$2a$';

				$salt = CryptHelper::repeatToLength($salt, 21);

				$salt = $prefix . CryptHelper::limitInteger($this->cost, 4, 31) . '$' . $salt . '$';
				break;
		}

		return crypt($password, $salt);
	}

	/**
	 * verify
	 *
	 * @param string $password
	 * @param string $hash
	 *
	 * @return  boolean
	 */
	public function verify($password, $hash)
	{
		return ($hash === crypt($password, $hash));
	}

	/**
	 * Method to get property Salt
	 *
	 * @return  string
	 */
	public function getSalt()
	{
		return $this->salt;
	}

	/**
	 * Method to set property salt
	 *
	 * @param   string $salt
	 *
	 * @return  static  Return self to support chaining.
	 */
	public function setSalt($salt)
	{
		$this->salt = $salt;

		return $this;
	}

	/**
	 * Method to get property Cost
	 *
	 * @return  int
	 */
	public function getCost()
	{
		return $this->cost;
	}

	/**
	 * Method to set property cost
	 *
	 * @param   int $cost
	 *
	 * @throws \InvalidArgumentException
	 * @return  static  Return self to support chaining.
	 */
	public function setCost($cost)
	{
		$this->cost = $cost;

		return $this;
	}
}
