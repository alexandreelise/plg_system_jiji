<?php
declare(strict_types=1);

/**
 * @package       AlterableTrait
 * @author        Alexandre ELISÉ <contact@alexandre-elise.fr>
 * @copyright (c) 2021 . Alexandre ELISÉ . Tous droits réservés.
 * @license       GPL-2.0-and-later GNU General Public License v2.0 or later
 * @link          https://coderparlerpartager.fr
 * Created Date : 02/01/2021
 * Created Time : 05:14
 */

namespace AE\Library\Jiji\Behavior;

\defined('_JEXEC') or die;

/**
 * Trait AlterableTrait
 * @package AE\Library\Jiji\Behavior
 */
trait AlterableTrait
{
	use UrlableTrait, DatableTrait;
}
