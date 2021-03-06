<?php
/**
 * Part of Windwalker project.
 *
 * @copyright  Copyright (C) 2008 - 2014 Asikart.com. All rights reserved.
 * @license    GNU Lesser General Public License version 2.1 or later.
 */

namespace Windwalker\Console\Prompter;

/**
 * General text prompter.
 *
 * @since  2.0
 */
class TextPrompter extends AbstractPrompter
{
	/**
	 * Show prompt to ask user.
	 *
	 * @param   string  $msg      Question.
	 * @param   string  $default  Default value.
	 *
	 * @return  string  The value that use input.
	 *
	 * @since   2.0
	 */
	public function ask($msg = '', $default = null)
	{
		$default = $default ? : $this->default;

		return $this->in($msg) ? : $default;
	}
}

