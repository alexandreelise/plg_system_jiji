<?php
declare(strict_types=1);
/**
 * @package       AlterableEndpoint
 * @author        Alexandre ELISÉ <contact@alexandre-elise.fr>
 * @copyright (c) 2021 . Alexandre ELISÉ . Tous droits réservés.
 * @license       GPL-2.0-and-later GNU General Public License v2.0 or later
 * @link          https://coderparlerpartager.fr
 * Created Date : 02/01/2021
 * Created Time : 05:21
 */
namespace AE\Library\Jiji\Data;

use AE\Library\Jiji\Behavior\AlterableTrait;

\defined('_JEXEC') or die;

/**
 * @package     AE\Library\Jiji\Data
 *
 * @since       version
 */
final class AlterableEndpoint implements EndpointInterface
{
	use AlterableTrait;
}
