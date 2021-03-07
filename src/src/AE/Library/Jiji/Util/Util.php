<?php
declare(strict_types=1);

/**
 * @package       Util
 * @author        Alexandre ELISÉ <contact@alexandre-elise.fr>
 * @copyright (c) 2021 . Alexandre ELISÉ . Tous droits réservés.
 * @license       GPL-2.0-and-later GNU General Public License v2.0 or later
 * @link          https://coderparlerpartager.fr
 * Created Date : 04/01/2021
 * Created Time : 17:21
 */

namespace AE\Library\Jiji\Util;

use InvalidArgumentException;
use Joomla\CMS\Factory;
use Throwable;
use function addslashes;
use function bin2hex;
use function chr;
use function json_decode;
use function json_encode;
use function str_replace;
use function stripslashes;
use function strncmp;
use function substr;
use const JSON_HEX_APOS;
use const JSON_HEX_QUOT;
use const JSON_THROW_ON_ERROR;
use const JSON_UNESCAPED_UNICODE;
use const PHP_EOL;

defined('_JEXEC') or die;

/**
 * @package     AE\Library\Jiji\Util
 *
 * @since       version
 */
abstract class Util
{
	/**
	 * @param   mixed  $value
	 *
	 * @return mixed
	 *
	 * @throws \JsonException
	 * @throws \JsonException
	 * @since version
	 */
	public static function jsonPhpToJs($value)
	{
		return str_replace("\u0022", "\\\\\"", json_encode($value, JSON_THROW_ON_ERROR | JSON_HEX_APOS | JSON_HEX_QUOT | JSON_UNESCAPED_UNICODE));
	}

	/**
	 * Verify if json string is valid and return it otherwise returns null
	 *
	 * @param   string  $value
	 *
	 * @return string|null
	 *
	 * @since version
	 */
	public static function jsonClean(string $value): ?string
	{
		if (empty($value))
		{
			return null;
		}

		$isValid = Util::validateJson($value);

		// return early if valid
		if ($isValid)
		{
			return $isValid ? $value : null;
		}

		//otherwise try to fix it and retry to validate
		$cleaned          = self::cleanUnwantedCharacters($value);
		$data_without_bom = self::removeBOM($cleaned);

		$stripped = stripslashes($data_without_bom);

		$doubleQuotes = self::replaceUnicodeDoubleQuote($stripped);

		$data = self::replaceUnicodeSingleQuote($doubleQuotes);

		$quoted = self::doubleEscapeSingleQuote($data);

		$result = null;

		$isValid = Util::validateJson($quoted);

		if (!$isValid)
		{
			throw new InvalidArgumentException('Your JSON file is invalid. Please correct it and try again.', 422);
		}

		try
		{
			$result = $isValid ? $quoted : null;
		}
		catch (JsonException $jsonException)
		{
			Factory::getContainer()->get(\Psr\Log\LoggerInterface::class)->error(
				'Data: ' . $quoted . PHP_EOL
				. ' File: ' . PHP_EOL
				. $jsonException->getFile()
				. ' Line: ' . PHP_EOL
				. $jsonException->getLine()
				. ' Message: ' . PHP_EOL
				. $jsonException->getMessage()
				. ' Trace: ' . PHP_EOL
				. $jsonException->getTraceAsString()
			);
		}
		catch (Throwable $exception)
		{
			Factory::getContainer()->get(\Psr\Log\LoggerInterface::class)->error(
				'Data: ' . $quoted . PHP_EOL
				. ' File: ' . PHP_EOL
				. $exception->getFile()
				. ' Line: ' . PHP_EOL
				. $exception->getLine()
				. ' Message: ' . PHP_EOL
				. $exception->getMessage()
				. ' Trace: ' . PHP_EOL
				. $exception->getTraceAsString()
			);
		}

		return $result;
	}


	/**
	 * @param   string  $value
	 *
	 * @param   bool    $assoc
	 * @param   int     $depth
	 *
	 * @return array|null
	 * @throws \JsonException
	 */
	public static function jsonJsToPhp(string $value, bool $assoc = true, int $depth = 512): ?array
	{
		if (empty($value))
		{
			return [];
		}

		$isValid = Util::validateJson($value);

		// return early if valid
		if ($isValid)
		{
			return json_decode($value, $assoc, $depth, JSON_THROW_ON_ERROR | JSON_HEX_APOS | JSON_HEX_QUOT | JSON_UNESCAPED_UNICODE);
		}

		//otherwise try to fix it and retry to validate
		$cleaned          = self::cleanUnwantedCharacters($value);
		$data_without_bom = self::removeBOM($cleaned);

		$stripped = stripslashes($data_without_bom);

		$doubleQuotes = self::replaceUnicodeDoubleQuote($stripped);

		$data = self::replaceUnicodeSingleQuote($doubleQuotes);

		$quoted = self::doubleEscapeSingleQuote($data);

		$result = null;

		$isValid = Util::validateJson($quoted);

		if (!$isValid)
		{
			throw new InvalidArgumentException('Your JSON file is invalid. Please correct it and try again.', 422);
		}

		try
		{
			$result = $isValid ? json_decode($quoted, $assoc, $depth, JSON_THROW_ON_ERROR | JSON_HEX_APOS | JSON_HEX_QUOT | JSON_UNESCAPED_UNICODE) : null;

		}
		catch (JsonException $jsonException)
		{
			Factory::getContainer()->get(\Psr\Log\LoggerInterface::class)->error(
				'Data: ' . $quoted . PHP_EOL
				. ' File: ' . PHP_EOL
				. $jsonException->getFile()
				. ' Line: ' . PHP_EOL
				. $jsonException->getLine()
				. ' Message: ' . PHP_EOL
				. $jsonException->getMessage()
				. ' Trace: ' . PHP_EOL
				. $jsonException->getTraceAsString()
			);
		}
		catch (Throwable $exception)
		{
			Factory::getContainer()->get(\Psr\Log\LoggerInterface::class)->error(
				'Data: ' . $quoted . PHP_EOL
				. ' File: ' . PHP_EOL
				. $exception->getFile()
				. ' Line: ' . PHP_EOL
				. $exception->getLine()
				. ' Message: ' . PHP_EOL
				. $exception->getMessage()
				. ' Trace: ' . PHP_EOL
				. $exception->getTraceAsString()
			);
		}

		return $result;
	}

	/**
	 * @param   string  $data
	 *
	 * @return bool
	 *
	 * @see   https://stackoverflow.com/a/3845829/8309401
	 *
	 * @since version 1.0.0
	 */
	public static function validateJson(string $data): bool
	{
		$pcre_regex = '/
  (?(DEFINE)
     (?<number>   -? (?= [1-9]|0(?!\d) ) \d+ (\.\d+)? ([eE] [+-]? \d+)? )
     (?<boolean>   true | false | null )
     (?<string>    " ([^"\\\\]* | \\\\ ["\\\\bfnrt\/] | \\\\ u [0-9a-f]{4} )* " )
     (?<array>     \[  (?:  (?&json)  (?: , (?&json)  )*  )?  \s* \] )
     (?<pair>      \s* (?&string) \s* : (?&json)  )
     (?<object>    \{  (?:  (?&pair)  (?: , (?&pair)  )*  )?  \s* \} )
     (?<json>   \s* (?: (?&number) | (?&boolean) | (?&string) | (?&array) | (?&object) ) \s* )
  )
  \A (?&json) \Z
  /six';

		return (preg_match($pcre_regex, $data) > 0);
	}


	/**
	 * remove BOM (Byte Order Mark)
	 *
	 * @param   string  $data
	 *
	 * @return false|string
	 */
	public static function removeBOM(string $data)
	{
		if (strncmp(bin2hex($data), 'efbbbf', 6) === 0)
		{
			return substr($data, 3);
		}

		return $data;
	}

	/**
	 * @param   string  $data
	 *
	 * @return string
	 */
	public static function replaceUnicodeDoubleQuote(string $data): string
	{
		return str_replace("\u0022", "\\\\\"", $data);
	}

	/**
	 * @param   string  $data
	 *
	 * @return string
	 */
	public static function replaceUnicodeSingleQuote(string $data): string
	{
		$first_pass = str_replace("\u0027", "\\\\'", $data);

		return str_replace('u0027', '\'', $first_pass);
	}

	/**
	 * This will remove unwanted characters.
	 * Check http://www.php.net/chr for details
	 *
	 * @param   string  $data
	 *
	 * @return string
	 */
	public static function cleanUnwantedCharacters(string $data): string
	{
		for ($i = 0; $i <= 31; ++$i)
		{
			$data = str_replace(chr($i), '', $data);
		}

		return str_replace(chr(127), '', $data);
	}

	/**
	 * Escape again single quote in json file for example
	 *
	 * @param   string  $data  single quote escaped once
	 *
	 * @return string
	 *
	 * @since version 1.0.0
	 */
	public static function doubleEscapeSingleQuote(string $data): string
	{
		return str_replace('\'', "\\'", addslashes($data));
	}

}
