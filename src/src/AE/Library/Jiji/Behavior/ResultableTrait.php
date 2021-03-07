<?php
declare(strict_types=1);

/**
 * @package       ResultableTrait
 * @author        Alexandre ELISÉ <contact@alexandre-elise.fr>
 * @copyright (c) 2021 . Alexandre ELISÉ . Tous droits réservés.
 * @license       GPL-2.0-and-later GNU General Public License v2.0 or later
 * @link          https://coderparlerpartager.fr
 * Created Date : 04/01/2021
 * Created Time : 10:50
 */


namespace AE\Library\Jiji\Behavior;

use Psr\Http\Message\ResponseInterface;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Style\SymfonyStyle;
use function strpos;

defined('_JEXEC') or die;

/**
 * Trait ResultableTrait
 * @package AE\Library\Jiji\Behavior
 */
trait ResultableTrait
{
	/**
	 * @param   \Psr\Http\Message\ResponseInterface            $result
	 * @param   \Symfony\Component\Console\Style\SymfonyStyle  $io
	 *
	 * @return int
	 *
	 * @since version
	 */
	protected function processResult(ResponseInterface $result, SymfonyStyle $io): int
	{
		//cast to string to easily search and match substrings in the status code
		$code = (string) $result->getStatusCode();

		if (mb_stripos($result->getHeaderLine('Content-Type'), 'text/html') !== false)
		{
			$io->error('Wrong response content type');

			return Command::FAILURE;
		}

		if (strpos($code, '4') === 0)
		{
			$io->warning($result->body);
		}
		elseif (strpos($code, '5') === 0)
		{
			$io->error($result->body);
		}
		elseif (strpos($code, '2') === 0)
		{
			$io->success($result->body);
		}
		else
		{
			$io->info($result->body);
		}

		return Command::SUCCESS;
	}
}
