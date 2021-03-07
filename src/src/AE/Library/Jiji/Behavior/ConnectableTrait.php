<?php
declare(strict_types=1);
/**
 * @package       Connectable
 * @author        Alexandre ELISÉ <contact@alexandre-elise.fr>
 * @copyright (c) 2020 . Alexandre ELISÉ . Tous droits réservés.
 * @license       GPL-2.0-and-later GNU General Public License v2.0 or later
 * @link          https://coderparlerpartager.fr
 * Created Date : 31/12/2020
 * Created Time : 21:41
 */

namespace AE\Library\Jiji\Behavior;

use Joomla\CMS\Factory;
use Joomla\CMS\Http\Http;
use Psr\Container\ContainerInterface;
use Psr\Http\Client\ClientInterface;
use function trim;
use const CURLOPT_CAINFO;
use const CURLOPT_DNS_CACHE_TIMEOUT;
use const CURLOPT_DNS_USE_GLOBAL_CACHE;
use const CURLOPT_NOBODY;
use const CURLOPT_SSL_VERIFYPEER;

\defined('_JEXEC') or die;

/**
 * Trait Connectable
 * @package AE\Library\Jiji\Behaviors
 */
trait ConnectableTrait
{
	/**
	 * @var string $basePath
	 * @since version
	 */
	private $basePath;

	/**
	 * @var string $apiToken
	 * @since version
	 */
	private $apiToken;

	/**
	 * @return mixed
	 */
	private function getBasePath(): string
	{
		return $this->basePath;
	}

	/**
	 * @param   string  $basePath  Base path of api request eg: https://example.com
	 *
	 * @return void
	 */
	private function setBasePath(string $basePath): void
	{
		$this->basePath = $basePath;
	}

	/**
	 * @return string
	 */
	private function getApiToken(): string
	{
		return $this->apiToken;
	}

	/**
	 * @param   string  $apiToken  Token of api request
	 *
	 * @return void
	 */
	private function setApiToken(string $apiToken): void
	{
		$this->apiToken = $apiToken;
	}

	/**
	 * WARNING: you must set CURLOPT_SSL_VERIFYPEER to true when not in dev enviroment
	 * Otherwise you might expose you site to really bad security issues
	 *
	 * @param   string  $apiToken  Token of api request
	 *
	 * @return \Psr\Http\Client\ClientInterface
	 *
	 * @since version
	 */
	private function getHttpClient(string $apiToken, bool $noBody = false): ClientInterface
	{
		Factory::getContainer()
			->share('http.client', function (ContainerInterface $container) use ($apiToken, $noBody) {
				$http = new Http(
					[
						'headers'        =>
							[
								'Content-Type'  => 'application/json',
								'Accept'        => 'application/vnd.api+json',
								'Authorization' => 'Bearer ' . trim($apiToken),
							],
						'transport.curl' => [
							CURLOPT_CAINFO               => '/opt/cacert.pem',
							CURLOPT_SSL_VERIFYPEER       => false,
							CURLOPT_DNS_USE_GLOBAL_CACHE => false,
							CURLOPT_DNS_CACHE_TIMEOUT    => 2,
							CURLOPT_NOBODY => $noBody,
						],
					]
				);

				return $http;
			},
				true
			);

		return Factory::getContainer()->get('http.client');
	}

}
