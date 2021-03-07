<?php
declare(strict_types=1);
/**
 * @package       Entity
 * @author        Alexandre ELISÉ <contact@alexandre-elise.fr>
 * @copyright (c) 2020 . Alexandre ELISÉ . Tous droits réservés.
 * @license       GPL-2.0-and-later GNU General Public License v2.0 or later
 * @link          https://coderparlerpartager.fr
 * Created Date : 31/12/2020
 * Created Time : 21:54
 */

namespace AE\Library\Jiji\Data;


use Joomla\Http\Response;
use Joomla\Http\Http;
use Psr\Http\Client\ClientInterface as ClientInterface;
use const CURLOPT_NOBODY;

\defined('_JEXEC') or die;

/**
 * Class Entity
 * @package AE\Data
 */
final class Entity
{
	/**
	 * @var string $basePath API request base path eg: https://example.com
	 * @since version 1.0.0
	 */
	protected $basePath;

	/**
	 * @var Http $httpClient
	 * @since version 1.0.0
	 */
	protected $httpClient;

	/**
	 * Default timeout
	 * @var int $timeout
	 * @since version
	 */
	protected $timeout = 10;

	/**
	 * Entity constructor.
	 *
	 * @param   ClientInterface  $httpClient
	 * @param   string           $basePath
	 */
	public function __construct(ClientInterface $httpClient, string $basePath, int $timeout = 10)
	{
		$this->httpClient = $httpClient;
		$this->basePath   = $basePath;
		$this->timeout    = $timeout;
	}

	/**
	 * @return int
	 */
	public function getTimeout(): int
	{
		return $this->timeout;
	}

	/**
	 * @param   int  $timeout
	 */
	public function setTimeout(int $timeout): void
	{
		$this->timeout = $timeout;
	}


	/**
	 * @param   \AE\Library\Jiji\Data\EndpointInterface  $endpoint
	 *
	 * @return \Joomla\Http\Response
	 *
	 * @since version
	 */
	public function browse(EndpointInterface $endpoint): Response
	{
		return $this->httpClient->get($this->basePath . $endpoint->getUrl(), [], $this->getTimeout());
	}

	/**
	 * @param   \AE\Library\Jiji\Data\EndpointInterface  $endpoint
	 *
	 * @return \Joomla\Http\Response
	 *
	 * @since version
	 */
	public function read(EndpointInterface $endpoint): Response
	{
		return $this->httpClient->get($this->basePath . $endpoint->getUrl(), [], $this->getTimeout());
	}

	/**
	 * @param   \AE\Library\Jiji\Data\EndpointInterface  $endpoint
	 *
	 * @return \Joomla\Http\Response
	 *
	 * @since version
	 */
	public function edit(EndpointInterface $endpoint): Response
	{
		return $this->httpClient->patch($this->basePath . $endpoint->getUrl(), $endpoint->getData(), [], $this->getTimeout());
	}

	/**
	 * @param   \AE\Library\Jiji\Data\EndpointInterface  $endpoint
	 *
	 * @return \Joomla\Http\Response
	 *
	 * @since version
	 */
	public function add(EndpointInterface $endpoint): Response
	{
		return $this->httpClient->post($this->basePath . $endpoint->getUrl(), $endpoint->getData(), [], $this->getTimeout());
	}

	/**
	 * @param   \AE\Library\Jiji\Data\EndpointInterface  $endpoint
	 *
	 * @return \Joomla\Http\Response
	 *
	 * @since version
	 */
	public function delete(EndpointInterface $endpoint): Response
	{
		return $this->httpClient->delete($this->basePath . $endpoint->getUrl(), [], $this->getTimeout(), null);
	}
}
