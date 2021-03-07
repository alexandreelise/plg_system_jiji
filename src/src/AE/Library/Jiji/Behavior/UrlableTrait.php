<?php
declare(strict_types=1);
/**
 * @package       UrlableTrait
 * @author        Alexandre ELISÉ <contact@alexandre-elise.fr>
 * @copyright (c) 2021 . Alexandre ELISÉ . Tous droits réservés.
 * @license       GPL-2.0-and-later GNU General Public License v2.0 or later
 * @link          https://coderparlerpartager.fr
 * Created Date : 02/01/2021
 * Created Time : 05:04
 */
namespace AE\Library\Jiji\Behavior;

\defined('_JEXEC') or die;

/**
 * Trait UrlableTrait
 * @package AE\Library\Jiji\Behavior
 */
trait UrlableTrait
{
	/**
	 * @var string $url
	 * @since version 1.0.0
	 */
     protected $url;

	/**
	 * @return string
	 */
	public function getUrl(): string
	{
		return $this->url;
	}

	/**
	 * @param   string  $url
	 *
	 * @return void
	 */
	public function setUrl(string $url): void
	{
		$this->url = $url;
	}
}
