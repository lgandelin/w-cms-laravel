<?php

namespace Webaccess\WCMSLaravel\Commands\Users;

use Webaccess\WCMSCore\Interactors\Users\CreateUserInteractor;
use Illuminate\Console\Command;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Input\InputArgument;

use Webaccess\WCMSCore\DataStructure;

class CreateUserCommand extends Command {

	/**
	 * The console command name.
	 *
	 * @var string
	 */
	protected $name = 'w-cms:user_create';

	/**
	 * The console command description.
	 *
	 * @var string
	 */
	protected $description = 'Create an admin user and generate a password';

	/**
	 * Create a new command instance.
	 *
	 * @return void
	 */
	public function __construct()
	{
		parent::__construct();
	}

	/**
	 * Execute the console command.
	 *
	 * @return mixed
	 */
	public function fire()
	{
		$login = $this->argument('login');
		$password = self::getRandomPassword();

		$userStructure = new DataStructure([
            'login' => $login,
            'password' => sha1($password),
            'last_name' => '',
            'first_name' => '',
            'email' => '',
        ]);
        
        (new CreateUserInteractor())->run($userStructure);

        $this->info('User successfullly created with following password : ' . $password);
	}

	/**
	 * Get the console command arguments.
	 *
	 * @return array
	 */
	protected function getArguments()
	{
		return array(
			array('login', InputArgument::REQUIRED, 'The user login'),
		);
	}

	private static function getRandomPassword($length = 8) {
        $chars = 'abcdefghkmnpqrstuvwxyz23456789';
        $count = mb_strlen($chars);

        for ($i = 0, $result = ''; $i < $length; $i++) {
            $index = rand(0, $count - 1);
            $result .= mb_substr($chars, $index, 1);
        }

        return $result;
    }

}
