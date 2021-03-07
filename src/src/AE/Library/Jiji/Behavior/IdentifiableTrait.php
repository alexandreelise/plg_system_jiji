<?php
declare(strict_types=1);
/**
 * @package       IdentifiableTrait
 * @author        Alexandre ELISÉ <contact@alexandre-elise.fr>
 * @copyright (c) 2021 . Alexandre ELISÉ . Tous droits réservés.
 * @license       GPL-2.0-and-later GNU General Public License v2.0 or later
 * @link          https://coderparlerpartager.fr
 * Created Date : 02/01/2021
 * Created Time : 07:10
 */

namespace AE\Library\Jiji\Behavior;

\defined('_JEXEC') or die;

/**
 * Trait IdentifiableTrait
 * @package AE\Library\Jiji\Behavior
 */
trait IdentifiableTrait
{
	/**
	 * @var int $id
	 * @since version 1.0.0
	 */
	protected $id;

	/**
	 * @return int
	 */
	public function getId()
	{
		return $this->id;
	}

	/**
	 * @param   int $id
	 */
	public function setId($id): void
	{
		$this->id = (int)$id;
	}

}
