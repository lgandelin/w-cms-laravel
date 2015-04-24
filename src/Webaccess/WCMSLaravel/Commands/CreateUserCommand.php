<?php

namespace Webaccess\WCMSLaravel\Commands;

use Illuminate\Console\Command;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Input\InputArgument;

use CMS\Structures\UserStructure;

class CreateUserCommand extends Command {

	/**
	 * The console command name.
	 *
	 * @var string
	 */
	protected $name = 'users:create';

	/**
	 * The console command description.
	 *
	 * @var string
	 */
	protected $description = 'Create a user in the database and generates a password';

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

		$userStructure = new UserStructure([
            'login' => $login,
            'password' => \Hash::make($password),
            'last_name' => '',
            'first_name' => '',
            'email' => '',
        ]);
        
        $userStructure = \App::make('CreateUserInteractor')->run($userStructure);

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
