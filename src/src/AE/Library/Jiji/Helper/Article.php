<?php
declare(strict_types=1);
/**
 * @package       Article
 * @author        Alexandre ELISÉ <contact@alexandre-elise.fr>
 * @copyright (c) 2021 . Alexandre ELISÉ . Tous droits réservés.
 * @license       GPL-2.0-and-later GNU General Public License v2.0 or later
 * @link          https://coderparlerpartager.fr
 * Created Date : 02/01/2021
 * Created Time : 08:03
 */

namespace AE\Library\Jiji\Helper;

use AE\Library\Jiji\Console\Article\AddArticleCommand;
use AE\Library\Jiji\Console\Article\BrowseArticleCommand;
use AE\Library\Jiji\Console\Article\DeleteArticleCommand;
use AE\Library\Jiji\Console\Article\EditArticleCommand;
use AE\Library\Jiji\Console\Article\ReadArticleCommand;
use Joomla\CMS\Factory;
use Psr\Container\ContainerInterface;

\defined('_JEXEC') or die;

/**
 * @package     AE\Library\Jiji\Helper
 *
 * @since       version 1.0.0
 */
abstract class Article
{
	/**
	 * Register custom commands related to article in Joomla! 4 based on API calls
	 * @since version 1.0.0
	 */
	public static function registerCommands(): void
	{
		//articles related commands

		Factory::getContainer()->share(
			'article.browse',
			function (ContainerInterface $container) {
				return new BrowseArticleCommand();
			},
			true
		);

		Factory::getContainer()->share(
			'article.read',
			function (ContainerInterface $container) {
				return new ReadArticleCommand();
			},
			true
		);

		Factory::getContainer()->share(
			'article.add',
			function (ContainerInterface $container) {
				return new AddArticleCommand();
			},
			true
		);

		Factory::getContainer()->share(
			'article.edit',
			function (ContainerInterface $container) {
				return new EditArticleCommand();
			},
			true
		);

		Factory::getContainer()->share(
			'article.delete',
			function (ContainerInterface $container) {
				return new DeleteArticleCommand();
			},
			true
		);

		// add article related commands

		// list all articles via api call
		Factory::getContainer()->get(\Joomla\CMS\Console\Loader\WritableLoaderInterface::class)->add('article:browse', 'article.browse');

		// show one article via api call
		Factory::getContainer()->get(\Joomla\CMS\Console\Loader\WritableLoaderInterface::class)->add('article:read', 'article.read');

		// edit one article via api call
		Factory::getContainer()->get(\Joomla\CMS\Console\Loader\WritableLoaderInterface::class)->add('article:edit', 'article.edit');

		// add one article via api call
		Factory::getContainer()->get(\Joomla\CMS\Console\Loader\WritableLoaderInterface::class)->add('article:add', 'article.add');

		// delete one article via api call
		Factory::getContainer()->get(\Joomla\CMS\Console\Loader\WritableLoaderInterface::class)->add('article:delete', 'article.delete');

	}
}
