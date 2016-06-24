<?php

namespace Collejo\App\Console\Commands;

use Illuminate\Console\Command;
use Collejo\Core\Contracts\Repository\UserRepository;

class AdminCreate extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'admin:create';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Creates a new super user account and assigns administrative roles';

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        $name = $this->ask('Enter name');
        $email = false;

        do{
            $email = $this->ask('Enter email');

            if (!$this->isValidEmail($email)) {
                $this->error('Enter a valid email address');
            }

        } while (!$this->isValidEmail($email));

        do{
            if ($this->accountExists($email)) {
                $this->error('There is already an account by this email');
                $email = $this->ask('Enter email');
            }

        } while ($this->accountExists($email));

        $password = $this->secret('Enter password');

        $this->userRepository->createAdminUser($name, $email, $password);
    }

    private function isValidEmail($email)
    {
        return filter_var($email, FILTER_VALIDATE_EMAIL);
    }

    private function accountExists($email)
    {
        return (bool) $this->userRepository->findByEmail($email);
    }

    public function __construct(UserRepository $userRepository)
    {
        parent::__construct();

        $this->userRepository = $userRepository;
    }
}