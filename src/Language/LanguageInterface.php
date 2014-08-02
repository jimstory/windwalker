<?php
/**
 * Part of Windwalker project. 
 *
 * @copyright  Copyright (C) 2011 - 2014 SMS Taiwan, Inc. All rights reserved.
 * @license    GNU General Public License version 2 or later; see LICENSE
 */

namespace Windwalker\Language;

/**
 * Interface LanguageInterface
 */
interface LanguageInterface
{
	/**
	 * translate
	 *
	 * @param string $key
	 *
	 * @return  string
	 */
	public function translate($key);

	/**
	 * plural
	 *
	 * @param string $string
	 * @param int    $count
	 *
	 * @return  string
	 */
	public function plural($string, $count = 1);

	/**
	 * sprintf
	 *
	 * @param string $key
	 *
	 * @return  mixed
	 */
	public function sprintf($key);

	/**
	 * exists
	 *
	 * @param string $key
	 *
	 * @return  boolean
	 */
	public function exists($key);
}
 