<?php

namespace App\Console\Commands;

use App\Service\UserExternalService;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Cache;

class RegisterUsersByExternalEndPoint extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:register-users-by-external-end-point';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Register users by external endpoint';

    public function __construct(
        protected UserExternalService $userExternalService
    ) {
        parent::__construct();
    }

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $paramSearch["nat"] = "br";
        $paramSearch["results"] = 10;
        $this->userExternalService->insertUsersByExternalApi($paramSearch);
        Cache::forget('active_users');
    }
}
