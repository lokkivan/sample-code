<?php

namespace App\Console\Commands;

use App\Helpers\SecretKeyHelper;
use Illuminate\Console\Command;

class SecretKeyGenerate extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'key:secret-key-generate';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Set the application secret-key';

    /**
     * Execute the console command.
     *
     * @return void
     */
    public function handle()
    {
        $secretKey = SecretKeyHelper::secretKeyGenerator();

        $this->setPrivateKeyInFile($secretKey['privateKey'] ?? '');
        $this->setPublicKeyInFile($secretKey['publicKey'] ?? '');

        $this->info("Application secret and public key set successfully.");
    }

    /**
     * @param $key
     */
    protected function setPrivateKeyInFile($key): void
    {
        $fp = fopen(SecretKeyHelper::getPrivateKeyPath(), 'w');
        fwrite($fp, $key);
        fclose($fp);
    }

    /**
     * @param $key
     */
    protected function setPublicKeyInFile($key): void
    {
        $fp = fopen(SecretKeyHelper::getPublicKeyPath(), 'w');
        fwrite($fp, $key);
        fclose($fp);
    }
}
