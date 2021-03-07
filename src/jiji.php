<?php
declare(strict_types=1);

/**
 * @package       jiji
 * @author        Alexandre ELISÉ <contact@alexandre-elise.fr>
 * @copyright (c) 2020 . Alexandre ELISÉ . Tous droits réservés.
 * @license       GPL-2.0-and-later GNU General Public License v2.0 or later
 * @link          https://coderparlerpartager.fr
 * Created Date : 30/12/2020
 * Created Time : 22:35
 */

use AE\Library\Jiji\Behavior\ConnectableTrait;
use AE\Library\Jiji\Console\Article\AddArticleCommand;
use AE\Library\Jiji\Console\Article\BrowseArticleCommand;
use AE\Library\Jiji\Console\HelloSuperJoomlerCommand;
use AE\Library\Jiji\Console\Article\ReadArticleCommand;
use AE\Library\Jiji\Data\Entity as Model;
use AE\Library\Jiji\Helper\Article;
use AE\Library\Jiji\Helper\HelloSuperJoomler;
use Joomla\CMS\Application\CMSApplication;
use Joomla\CMS\Factory;
use Joomla\CMS\Plugin\CMSPlugin;
use Joomla\Database\DatabaseDriver;
use Joomla\Event\DispatcherInterface;
use Joomla\Event\SubscriberInterface;
use Psr\Container\ContainerInterface;

\defined('_JEXEC') or die;

//autoload custom library
JLoader::registerNamespace('\\AE\\Library\\Jiji', __DIR__ . '/src/AE/Library/Jiji', false, true,'psr4');


/**
 * Plugin class
 * @package     jiji
 *
 * @since       version
 */
class PlgSystemJiji extends CMSPlugin implements SubscriberInterface
{
	use ConnectableTrait;

	/**
	 * @var \Joomla\CMS\Application\CMSApplication $app
	 * @since version
	 */
	protected $app;

	/**
	 * @var DatabaseDriver $db
	 * @since version
	 */
	protected $db;

	/**
	 * @var bool $autoloadLanguage
	 * @since version
	 */
	protected $autoloadLanguage = true;

	/**
	 * Choose which events this plugin is subscribed to and will respond to
	 * @return string[]
	 *
	 * @since version
	 */
	public static function getSubscribedEvents(): array
	{
		return [
			\Joomla\Application\ApplicationEvents::BEFORE_EXECUTE => 'registerCommands',
		];
	}

	/**
	 * Register custom commands
	 *
	 * @since version
	 */
	public function registerCommands(): void
	{
		HelloSuperJoomler::registerCommands();

		Article::registerCommands();

	}

}
