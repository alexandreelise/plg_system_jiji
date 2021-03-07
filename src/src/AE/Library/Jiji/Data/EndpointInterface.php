<?php
declare(strict_types=1);

/**
 * @package       EndpointInterface
 * @author        Alexandre ELISÉ <contact@alexandre-elise.fr>
 * @copyright (c) 2021 . Alexandre ELISÉ . Tous droits réservés.
 * @license       GPL-2.0-and-later GNU General Public License v2.0 or later
 * @link          https://coderparlerpartager.fr
 * Created Date : 02/01/2021
 * Created Time : 05:38
 */

namespace AE\Library\Jiji\Data;

\defined('_JEXEC') or die;


/**
 * Interface EndpointInterface
 * @package AE\Library\Jiji\Data
 */
interface EndpointInterface
{
	/**
	 *
	 * @return string
	 *
	 * @since version 1.0.0
	 */
	public function getUrl(): string;

	/**
	 * @param   string  $url
	 *
	 *
	 * @since version 1.0.0
	 */
	public function setUrl(string $url): void;
}
