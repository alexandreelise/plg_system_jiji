<?php
declare(strict_types=1);
/**
 * @package       BrowseArticleCommand
 * @author        Alexandre ELISÉ <contact@alexandre-elise.fr>
 * @copyright (c) 2020 . Alexandre ELISÉ . Tous droits réservés.
 * @license       GPL-2.0-and-later GNU General Public License v2.0 or later
 * @link          https://coderparlerpartager.fr
 * Created Date : 31/12/2020
 * Created Time : 20:06
 */

namespace AE\Library\Jiji\Console\Article;

use AE\Library\Jiji\Behavior\CommandableTrait;
use AE\Library\Jiji\Behavior\ComputableTrait;
use AE\Library\Jiji\Behavior\ConnectableTrait;
use AE\Library\Jiji\Behavior\ResultableTrait;
use AE\Library\Jiji\Data\Endpoint;
use AE\Library\Jiji\Data\Entity;
use Joomla\Console\Command\AbstractCommand;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Style\SymfonyStyle;
use function strpos;

\defined('_JEXEC') or die;

/**
 * Class BrowseArticleCommand
 * @package AE\Library\Jiji\Console\Article
 */
final class BrowseArticleCommand extends AbstractCommand
{
	use ComputableTrait,
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
	protected static $defaultName = 'article:browse';

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
		$endpoint->setUrl('/api/v1/content/article');

		$model = new Entity($httpClient, $basePath);

		$result = $model->browse($endpoint);

		return $this->processResult($result, $io);
	}

	protected function configure(): void
	{
		$this->setDescription('Browse article using cli');
		$this->setHelp("<info>%command.name%</info> List available entities \n type the entity name as argument after the command.\n For example: <info>%command.name%</info> article:browse \n");
		$this->commandableConfigure();
	}

}
