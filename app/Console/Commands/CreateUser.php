<?php

namespace App\Console\Commands;

use App\Models\User;
use App\Repositories\UserRepository;
use GuzzleHttp\Client as Client;
use Illuminate\Console\Command;
use Validator;

/**
 * Class CreateUser
 * @package App\Console\Commands
 */
class CreateUser extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'user:create';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command for create guest user';

    /**
     * @var string
     */
    private $lastError = '';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $this->info('Start create new user');

        /** @var User $user */
        $user = (new UserRepository())->createEmptyUser();
        $validationRules = $user->validationRules();
        $inputArgs = $this->getInputArgs($validationRules);
        $user->fill($inputArgs);
        $user->save();

        $this->info("User with email {$user->email} was created");
    }

    /**
     * @param array
     * @return array
     */
    private function getInputArgs(array $validationRules): array
    {
        $result = [];

        foreach ($validationRules as $attribute => $rule) {
            $value = $this->ask(ucfirst($attribute) . ' ?');

            while (!$this->validateInputArg([$attribute => $value], [$attribute => $rule])) {
                $this->error($this->lastError);
                $value = $this->ask(ucfirst($attribute) . ' ?');
            }

            $result[$attribute] = $value;
        }

        return $result;
    }

    /**
     * @param array $args
     * @param $rules
     * @return bool
     */
    private function validateInputArg(array $args, array $rules): bool
    {
        $validator = Validator::make($args, $rules);

        if ($validator->fails()) {
            $this->lastError = implode(PHP_EOL, $validator->errors()->all());

            return false;
        }

        return true;
    }
}
