<?php
declare(strict_types=1);
/**
 * @package       Data
 * @author        Alexandre ELISÉ <contact@alexandre-elise.fr>
 * @copyright (c) 2021 . Alexandre ELISÉ . Tous droits réservés.
 * @license       GPL-2.0-and-later GNU General Public License v2.0 or later
 * @link          https://coderparlerpartager.fr
 * Created Date : 04/01/2021
 * Created Time : 13:25
 */

namespace AE\Library\Jiji\Helper;

use AE\Library\Jiji\Core\Constant;
use InvalidArgumentException;
use RuntimeException;
use function file_exists;
use function file_get_contents;
use function json_decode;
use function preg_replace;
use function realpath;
use function sprintf;

defined('_JEXEC') or die;

/**
 * @package     AE\Library\Jiji\Helper
 *
 * @since       version
 */
abstract class Data
{
	/**
	 * Simple read file
	 *
	 * @param   string  $filename  name of the to read
	 *
	 * @return string
	 *
	 * @since version 1.0.0
	 */
	public static function simpleReadFile(string $filename): string
	{
		$path = realpath($filename);

		if ($path === false) {
			throw new InvalidArgumentException(sprintf('%s is not a file', $filename), 404);
		}

		if (!file_exists($path))
		{
			throw new InvalidArgumentException(sprintf('%s file does not exists', $filename), 404);
		}

		$content = file_get_contents($filename);

		if (false === $content)
		{
			throw new RuntimeException(sprintf('Could not read file %s', $filename), 422);
		}

		return trim($content);
	}
}
