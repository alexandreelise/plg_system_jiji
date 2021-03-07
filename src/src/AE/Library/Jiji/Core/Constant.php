<?php
declare(strict_types=1);

/**
 * @package       Constant
 * @author        Alexandre ELISÉ <contact@alexandre-elise.fr>
 * @copyright (c) 2021 . Alexandre ELISÉ . Tous droits réservés.
 * @license       GPL-2.0-and-later GNU General Public License v2.0 or later
 * @link          https://coderparlerpartager.fr
 * Created Date : 04/01/2021
 * Created Time : 16:35
 */

namespace AE\Library\Jiji\Core;

use const JSON_HEX_AMP;
use const JSON_HEX_APOS;
use const JSON_HEX_QUOT;
use const JSON_HEX_TAG;

defined('_JEXEC') or die;

/**
 * @package     AE\Library\Jiji\Core
 *
 * @since       version 1.0.0
 */
abstract class Constant
{
	/**
	 * json decode default flags
	 */
	public const JSON_DEFAULTS = JSON_HEX_QUOT | JSON_HEX_APOS | JSON_HEX_AMP | JSON_HEX_TAG;
}
