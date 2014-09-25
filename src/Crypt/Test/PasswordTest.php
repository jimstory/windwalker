<?php
/**
 * Part of Windwalker project Test files.
 *
 * @copyright  Copyright (C) 2011 - 2014 SMS Taiwan, Inc. All rights reserved.
 * @license    GNU General Public License version 2 or later; see LICENSE
 */

namespace Windwalker\Crypt\Test;

use Windwalker\Crypt\Password;

/**
 * Test class of Password
 *
 * @since {DEPLOY_VERSION}
 */
class PasswordTest extends \PHPUnit_Framework_TestCase
{
	/**
	 * Test instance.
	 *
	 * @var Password
	 */
	protected $instance;

	/**
	 * Sets up the fixture, for example, opens a network connection.
	 * This method is called before a test is executed.
	 *
	 * @return void
	 */
	protected function setUp()
	{
		$this->instance = new Password(10, 'sakura');
	}

	/**
	 * Tears down the fixture, for example, closes a network connection.
	 * This method is called after a test is executed.
	 *
	 * @return void
	 */
	protected function tearDown()
	{
	}

	/**
	 * Method to test create().
	 *
	 * @return void
	 *
	 * @covers Windwalker\Crypt\Password::create
	 * @covers Windwalker\Crypt\Password::verify
	 */
	public function testCreateMd5()
	{
		$pass = $this->instance->create('windwalker', Password::MD5);

		$this->assertEquals(crypt('windwalker', '$1$sakura$'), $pass);

		$this->assertTrue($this->instance->verify('windwalker', $pass));

		// Use default
		$password = new Password;

		$this->assertTrue($password->verify('windwalker', $pass), $password->create('windwalker', Password::MD5));
	}

	/**
	 * Method to test create().
	 *
	 * @return void
	 *
	 * @covers Windwalker\Crypt\Password::create
	 * @covers Windwalker\Crypt\Password::verify
	 */
	public function testCreateSha256()
	{
		$this->instance->setCost(5000);

		$pass = $this->instance->create('windwalker', Password::SHA256);

		$this->assertEquals(crypt('windwalker', '$5$rounds=5000$sakura$'), $pass);

		$this->assertTrue($this->instance->verify('windwalker', $pass));


		// Cost less than 1000 will be 1000
		$this->instance->setCost(125);

		$pass = $this->instance->create('windwalker', Password::SHA256);

		$this->assertEquals(crypt('windwalker', '$5$rounds=1000$sakura$'), $pass);

		$this->assertTrue($this->instance->verify('windwalker', $pass));

		// Use default
		$password = new Password;

		$this->assertTrue($password->verify('windwalker', $pass), $password->create('windwalker', Password::SHA256));
	}

	/**
	 * Method to test create().
	 *
	 * @return void
	 *
	 * @covers Windwalker\Crypt\Password::create
	 * @covers Windwalker\Crypt\Password::verify
	 */
	public function testCreateSha512()
	{
		$this->instance->setCost(5000);

		$pass = $this->instance->create('windwalker', Password::SHA512);

		$this->assertEquals(crypt('windwalker', '$6$rounds=5000$sakura$'), $pass);

		$this->assertTrue($this->instance->verify('windwalker', $pass));


		// Cost less than 1000 will be 1000
		$this->instance->setCost(125);

		$pass = $this->instance->create('windwalker', Password::SHA512);

		$this->assertEquals(crypt('windwalker', '$6$rounds=1000$sakura$'), $pass);

		$this->assertTrue($this->instance->verify('windwalker', $pass));

		// Use default
		$password = new Password;

		$this->assertTrue($password->verify('windwalker', $pass), $password->create('windwalker', Password::SHA512));
	}

	/**
	 * Method to test create().
	 *
	 * @return void
	 *
	 * @covers Windwalker\Crypt\Password::create
	 * @covers Windwalker\Crypt\Password::verify
	 */
	public function testCreateBlowfish()
	{
		$pass = $this->instance->create('windwalker', Password::BLOWFISH);

		$prefix = (version_compare(PHP_VERSION, '5.3.7') >= 0) ? '$2y$' : '$2a$';

		$this->assertEquals(crypt('windwalker', $prefix . '10$sakurasakurasakurasaku$'), $pass);

		$this->assertTrue($this->instance->verify('windwalker', $pass));

		// Use default
		$password = new Password;

		$this->assertTrue($password->verify('windwalker', $pass), $password->create('windwalker', Password::BLOWFISH));
	}

	/**
	 * Method to test getSalt().
	 *
	 * @return void
	 *
	 * @covers Windwalker\Crypt\Password::getSalt
	 * @TODO   Implement testGetSalt().
	 */
	public function testGetSalt()
	{
		// Remove the following lines when you implement this test.
		$this->markTestIncomplete(
			'This test has not been implemented yet.'
		);
	}

	/**
	 * Method to test setSalt().
	 *
	 * @return void
	 *
	 * @covers Windwalker\Crypt\Password::setSalt
	 * @TODO   Implement testSetSalt().
	 */
	public function testSetSalt()
	{
		// Remove the following lines when you implement this test.
		$this->markTestIncomplete(
			'This test has not been implemented yet.'
		);
	}

	/**
	 * Method to test getCost().
	 *
	 * @return void
	 *
	 * @covers Windwalker\Crypt\Password::getCost
	 * @TODO   Implement testGetCost().
	 */
	public function testGetCost()
	{
		// Remove the following lines when you implement this test.
		$this->markTestIncomplete(
			'This test has not been implemented yet.'
		);
	}

	/**
	 * Method to test setCost().
	 *
	 * @return void
	 *
	 * @covers Windwalker\Crypt\Password::setCost
	 * @TODO   Implement testSetCost().
	 */
	public function testSetCost()
	{
		// Remove the following lines when you implement this test.
		$this->markTestIncomplete(
			'This test has not been implemented yet.'
		);
	}
}
