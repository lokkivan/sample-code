<?php

namespace App\Console\Commands;

use App\Models\User;
use App\Repositories\UserRepository;
use Illuminate\Console\Command;

class ChangeUserRole extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'user:change-role';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command for change user role';

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        $this->info('Change role for user');

        $userData = $this->ask('Enter id or email of user');
        $userRepository = new UserRepository();

        if ($userData == (int)$userData) {
            $user = $userRepository->findById($userData);
        } else {
            $user = $userRepository->findByEmail($userData);
        }

        if ($user === null) {
            $this->error("User with identificator $userData not found");
            exit(-1);
        }

        $this->info('Choose available role for user: ' . $user->name);
        $availableRoles = User::getAvailableRoles();

        foreach ($availableRoles as $roleId => $role) {
            $this->info("$roleId) $role");
        }

        $newRoleId = (int)$this->ask('?');

        if ($newRoleId >= 0 && $newRoleId <= count($availableRoles) - 1) {
            $user->role = $availableRoles[$newRoleId];
            $user->save();
        } else {
            $this->error("Incorrect role id $newRoleId");
            exit(-1);
        }

        $this->info("New role {$availableRoles[$newRoleId]} for user {$user->name} is applied");
    }
}