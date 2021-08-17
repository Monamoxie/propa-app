<?php

namespace App\Console\Commands;

use App\Services\PropertyService;
use Illuminate\Console\Command;

class CallLoader extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'load:data';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Load data from remote mtc server';

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
     * @return int
     */
    public function handle(PropertyService $propertyService)
    {
        return $propertyService->loadFromApi();
    }
}
