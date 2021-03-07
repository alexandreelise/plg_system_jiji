<?php
declare(strict_types=1);

/**
 * @package       CommandableTrait
 * @author        Alexandre ELISÉ <contact@alexandre-elise.fr>
 * @copyright (c) 2021 . Alexandre ELISÉ . Tous droits réservés.
 * @license       GPL-2.0-and-later GNU General Public License v2.0 or later
 * @link          https://coderparlerpartager.fr
 * Created Date : 02/01/2021
 * Created Time : 06:41
 */

namespace AE\Library\Jiji\Behavior;

use InvalidArgumentException;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Style\SymfonyStyle;
use function filter_var;
use function is_string;
use function sprintf;
use const FILTER_VALIDATE_URL;

\defined('_JEXEC') or die;

/**
 * Trait CommandableTrait
 * @package AE\Library\Jiji\Behavior
 */
trait CommandableTrait
{
	/**
	 * Configure the command.
	 *
	 * @return  void
	 *
	 * @since   2.0.0
	 */
	protected function configure(): void
	{
		$this->addOption(
			'base-path',
			'b',
			InputOption::VALUE_REQUIRED,
			'What is your Joomla! 4 website base path ?',
			'https://example.com'
		);
		$this->addOption(
			'api-token',
			't',
			InputOption::VALUE_REQUIRED,
			'Please enter you API Token',
			''
		);
		$this->addOption('item-data', 'd', InputOption::VALUE_REQUIRED, 'Please provide entity data as json file (eg: article data as json file)', 'test-article.json');
		$this->addOption('id', null, InputOption::VALUE_REQUIRED, 'Please provide entity id (eg: article id)', 1);
		parent::configure();
	}


	/**
	 * @param   \Symfony\Component\Console\Input\InputInterface    $input
	 * @param   \Symfony\Component\Console\Output\OutputInterface  $output
	 *
	 *
	 * @since version 1.0.0
	 */
	protected function initialise(InputInterface $input, OutputInterface $output): void
	{
		$io = new SymfonyStyle($input, $output);
		$io->title($this->getComputedName() . ' using cli');

		//interactive true or false?
		$isInteractive = !(bool) $input->getOption('no-interaction');
		$input->setInteractive($isInteractive);


		$basePath = $io->ask('What is your Joomla! 4 website base path ?', 'https://example.com', function ($value) {
			if (false === filter_var($value, FILTER_VALIDATE_URL))
			{
				throw new \InvalidArgumentException(sprintf('%s is not a valid url', $value), 422);
			}

			return $value;
		});

		$confirmBasePath = $io->confirm(sprintf('Is your base path %s ?', $basePath), true);

		if (false === $confirmBasePath)
		{
			throw new InvalidArgumentException('Please try again', 422);
		}

		$apiToken = $io->askHidden('Enter you API Token', function ($value) {
			if (empty($value) || !is_string($value))
			{
				throw new \InvalidArgumentException('Token cannot be empty and must be a string', 422);
			}

			return $value;
		});

		// set values at the end to be more efficient when refactoring
		$this->setBasePath($input->isInteractive() ? $basePath : $input->getOption('base-path') ?? '');

		$this->setApiToken($input->isInteractive() ? $apiToken : $input->getOption('api-token') ?? '');

		parent::initialise($input, $output);
	}

}
