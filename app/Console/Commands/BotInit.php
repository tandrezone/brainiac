<?php

namespace App\Console\Commands;

use App\Services\ExchangeService;
use Illuminate\Console\Command;

class BotInit extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'bot:init';

    protected $exchange;
    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Init command, get trades and balances';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->exchange = new ExchangeService();
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        $this->exchange->init();
        return Command::SUCCESS;
    }
}
