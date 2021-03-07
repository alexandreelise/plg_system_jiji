<?php
declare(strict_types=1);
/**
 * @package       DatableTrait
 * @author        Alexandre ELISÉ <contact@alexandre-elise.fr>
 * @copyright (c) 2021 . Alexandre ELISÉ . Tous droits réservés.
 * @license       GPL-2.0-and-later GNU General Public License v2.0 or later
 * @link          https://coderparlerpartager.fr
 * Created Date : 02/01/2021
 * Created Time : 05:07
 */

namespace AE\Library\Jiji\Behavior;

\defined('_JEXEC') or die;

/**
 * @package     AE\Library\Jiji\Behavior
 *
 * @since       version
 */
trait DatableTrait
{
	/**
	 * @var string $data
	 * @since version 1.0.0
	 */
	protected $data = '';

	/**
	 * @return string
	 */
	public function getData(): string
	{
		return $this->data;
	}

	/**
	 * @param   string  $data data sent in request altering the state of the resource
	 */
	public function setData(string $data): void
	{
		$this->data = $data;
	}

}
