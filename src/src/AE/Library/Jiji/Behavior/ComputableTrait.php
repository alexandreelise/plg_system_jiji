<?php
declare(strict_types=1);
/**
 * @package       Computable
 * @author        Alexandre ELISÉ <contact@alexandre-elise.fr>
 * @copyright (c) 2020 . Alexandre ELISÉ . Tous droits réservés.
 * @license       GPL-2.0-and-later GNU General Public License v2.0 or later
 * @link          https://coderparlerpartager.fr
 * Created Date : 31/12/2020
 * Created Time : 20:11
 */

namespace AE\Library\Jiji\Behavior;

\defined('_JEXEC') or die;

/**
 * Trait Computable
 * @package AE\Library\Jiji\Behaviors
 */
trait ComputableTrait
{
	/**
	 * Get command class name without the suffix 'Command'
	 *
	 * @return string
	 *
	 * @since version
	 */
	private function getComputedName(): string
	{
		return str_replace('Command', '', __CLASS__);
	}
}
