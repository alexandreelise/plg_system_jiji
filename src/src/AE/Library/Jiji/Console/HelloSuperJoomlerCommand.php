<?php
declare(strict_types=1);
/**
 * @package       HelloSuperJoomlerCommand
 * @author        Alexandre ELISÉ <contact@alexandre-elise.fr>
 * @copyright (c) 2020 . Alexandre ELISÉ . Tous droits réservés.
 * @license       GPL-2.0-and-later GNU General Public License v2.0 or later
 * @link          https://coderparlerpartager.fr
 * Created Date : 30/12/2020
 * Created Time : 20:52
 */

namespace AE\Library\Jiji\Console;

use Joomla\CMS\Language\Text;
use Joomla\Console\Command\AbstractCommand;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Style\SymfonyStyle;
use function is_string;

defined('_JEXEC') or die;

/**
 * @package     AE\Console
 *
 * @since       version
 */
class HelloSuperJoomlerCommand extends AbstractCommand
{
	/**
	 * The default command name
	 *
	 * @var    string
	 * @since  4.0.0
	 */
	protected static $defaultName = 'jiji:hello';

	/**
	 * @var string $message
	 * @since version 1.0.0
	 */
	private $message = 'Helllloooooo';

	/**
	 * @var string $name
	 * @since version 1.0.0
	 */
	private $name = 'Super joomler';
	/**
	 * Configure the command.
	 *
	 * @return  void
	 *
	 * @since   4.0.0
	 */
	protected function configure(): void
	{
		$this->setDescription('This command says a "punchy" hello to you when you call it');
		$this->setHelp(
			<<<EOF
The <info>%command.name%</info> command says a "punchy" hello to you when you call it
<info>php %command.full_name%</info>
EOF
		);
	}

	/**
	 * @param   \Symfony\Component\Console\Input\InputInterface    $input
	 * @param   \Symfony\Component\Console\Output\OutputInterface  $output
	 *
	 *
	 * @since version 1.0.0
	 */
	protected function initialise(InputInterface $input, OutputInterface $output): void
	{
		$io = new SymfonyStyle($input, $output);

		$this->name = $io->ask('What is your name?', 'Super joomler', function ($value) {
			if (empty($value) || !is_string($value))
			{
				throw new \RuntimeException('Your name cannot be empty.Are you a robot?');
			}

			return $value;
		});

		$this->message = Text::sprintf('PLG_SYSTEM_JIJI_PUNCHY_GREETING', $this->name);

		parent::initialise($input, $output);
	}


	/**
	 * @param   \Symfony\Component\Console\Input\InputInterface    $input
	 * @param   \Symfony\Component\Console\Output\OutputInterface  $output
	 *
	 * @return int
	 *
	 * @since version 1.0.0
	 */
	protected function doExecute(InputInterface $input, OutputInterface $output): int
	{
		$io = new SymfonyStyle($input, $output);

		$io->success($this->message);

		return Command::SUCCESS;
	}
}
