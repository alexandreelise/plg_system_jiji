<?php
declare(strict_types=1);
/**
 * @package       EditArticleCommand
 * @author        Alexandre ELISÉ <contact@alexandre-elise.fr>
 * @copyright (c) 2020 . Alexandre ELISÉ . Tous droits réservés.
 * @license       GPL-2.0-and-later GNU General Public License v2.0 or later
 * @link          https://coderparlerpartager.fr
 * Created Date : 31/12/2020
 * Created Time : 20:07
 */

namespace AE\Library\Jiji\Console\Article;

use AE\Library\Jiji\Behavior\CommandableTrait;
use AE\Library\Jiji\Behavior\ComputableTrait;
use AE\Library\Jiji\Behavior\ConnectableTrait;
use AE\Library\Jiji\Behavior\IdentifiableTrait;
use AE\Library\Jiji\Behavior\ResultableTrait;
use AE\Library\Jiji\Data\AlterableEndpoint;
use AE\Library\Jiji\Data\Entity;
use AE\Library\Jiji\Helper\Data;
use AE\Library\Jiji\Util\Text;
use AE\Library\Jiji\Util\Util;
use InvalidArgumentException;
use Joomla\Console\Command\AbstractCommand;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Style\SymfonyStyle;

\defined('_JEXEC') or die;

/**
 * Class EditArticleCommand
 * @package AE\Library\Jiji\Console\Article
 */
final class EditArticleCommand extends AbstractCommand
{
	use IdentifiableTrait,
		ComputableTrait,
		ConnectableTrait,
		ResultableTrait,
		CommandableTrait
	{
		CommandableTrait::configure as commandableConfigure;
		CommandableTrait::initialise as commandableInitialise;
	}

	/**
	 * @var string $defaultName
	 * @since version
	 */
	protected static $defaultName = 'article:edit';

	/**
	 * @param   \Symfony\Component\Console\Input\InputInterface    $input
	 * @param   \Symfony\Component\Console\Output\OutputInterface  $output
	 *
	 * @return int
	 */
	protected function doExecute(InputInterface $input, OutputInterface $output): int
	{
		$io = new SymfonyStyle($input, $output);

		$httpClient = $this->getHttpClient($this->getApiToken());
		$basePath   = $this->getBasePath();
		$endpoint   = new AlterableEndpoint;
		$endpoint->setUrl('/api/v1/content/article/' . $this->getId());

		$itemDataFilename = (string) $input->getOption('item-data');

		try
		{
			// read a json filename provided by --item-data option
			$data = Data::simpleReadFile($itemDataFilename);

			$cleanedJsonData = Util::jsonClean($data);
		}
		catch (InvalidArgumentException $invalidArgumentException)
		{
			// use a directly provided json string --item-data option
			$cleanedJsonData = Util::jsonClean($itemDataFilename);
		}
		catch (Throwable $exception)
		{
			// use a directly provided json string --item-data option
			$cleanedJsonData = Util::jsonClean($itemDataFilename);
		}

		$endpoint->setData($cleanedJsonData ?? Util::jsonClean(Util::jsonPhpToJs([
				'title' => \Joomla\String\StringHelper::increment('Jiji altered test article', 'dash'),
				'alias' => \Joomla\String\StringHelper::increment('jiji-altered-test-article', 'dash'),
			])));

		$model = new Entity($httpClient, $basePath);

		$result = $model->edit($endpoint);

		return $this->processResult($result, $io);
	}


	protected function configure(): void
	{
		$this->setDescription('Edit article using cli');
		$this->setHelp("<info>%command.name%</info> Edit an entity by id \n type the entity name as argument after the command.\n For example: <info>%command.name%</info> article:edit \n");
		$this->commandableConfigure();
	}

	protected function initialise(InputInterface $input, OutputInterface $output): void
	{
		$this->commandableInitialise($input, $output);

		$io = new SymfonyStyle($input, $output);
		$id = $io->ask('Please provide an article id', '1', function ($value) {
			if (empty($value))
			{
				throw new \InvalidArgumentException(sprintf('%s cannot be empty', $value));
			}

			return $value;
		});
		$this->setId($input->isInteractive() ? $id : $input->getOption('id'));
	}

}
