<?php
declare(strict_types=1);
/**
 * @package       ReadArticleCommand
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
use AE\Library\Jiji\Data\Endpoint;
use AE\Library\Jiji\Data\Entity;
use AE\Library\Jiji\Util\Text;
use Joomla\Console\Command\AbstractCommand;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Style\SymfonyStyle;
use function sprintf;

\defined('_JEXEC') or die;

/**
 * Class ReadArticleCommand
 * @package AE\Library\Jiji\Console\Article
 */
final class ReadArticleCommand extends AbstractCommand
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
	protected static $defaultName = 'article:read';

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
		$endpoint   = new Endpoint;
		$endpoint->setUrl('/api/v1/content/article/' . $this->getId());
		$model = new Entity($httpClient, $basePath);

		$result = $model->read($endpoint);

		return $this->processResult($result, $io);
	}


	protected function configure(): void
	{
		$this->setDescription('Read article using cli');
		$this->setHelp("<info>%command.name%</info> Read an entity by id \n type the entity name as argument after the command.\n For example: <info>%command.name%</info> article:read \n");
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
