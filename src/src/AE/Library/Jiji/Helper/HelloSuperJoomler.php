<?php
declare(strict_types=1);
/**
 * @package       HelloSuperJoomler
 * @author        Alexandre ELISÉ <contact@alexandre-elise.fr>
 * @copyright (c) 2021 . Alexandre ELISÉ . Tous droits réservés.
 * @license       GPL-2.0-and-later GNU General Public License v2.0 or later
 * @link          https://coderparlerpartager.fr
 * Created Date : 02/01/2021
 * Created Time : 08:11
 */

namespace AE\Library\Jiji\Helper;

use AE\Library\Jiji\Console\HelloSuperJoomlerCommand;
use Joomla\CMS\Factory;
use Psr\Container\ContainerInterface;

\defined('_JEXEC') or die;

/**
 * @package     AE\Library\Jiji\Helper
 *
 * @since       version 1.0.0
 */
abstract class HelloSuperJoomler
{
	/**
	 * Register simple custom command
	 *
	 * @since version 1.0.0
	 */
	public static function registerCommands(): void
	{
		//hello super joomler command
		Factory::getContainer()->share(
			'jiji.hello',
			function (ContainerInterface $container) {
				return new HelloSuperJoomlerCommand;
			},
			true
		);

		// add hello super joomlers command to joomla.php cli script
		Factory::getContainer()->get(\Joomla\CMS\Console\Loader\WritableLoaderInterface::class)->add('jiji:hello', 'jiji.hello');

	}
}
