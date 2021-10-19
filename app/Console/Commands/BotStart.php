<?php

namespace App\Console\Commands;

use ccxt\bitstamp;
use Illuminate\Console\Command;

class BotStart extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'bot:start';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Starts the crypto bot';

    protected $exchange;
    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->exchange = new bitstamp(array(
            'apiKey' => env("API_KEY"),
            'secret' => env('API_SECRET'),
        ));
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        //get needed info
        $balance = $this->exchange->fetch_balance();
        $freeCoins = [];
        foreach($balance['free'] as $symbol=>$value) {
            if($value != 0) {
                $freeCoins[] = [$symbol, $value];
            }
        }
        $trades = $this->exchange->fetch_my_trades();
        //save trades to debug later

        $this->table(
            ['Symbol','Value'],
            $freeCoins
        );
        return Command::SUCCESS;
    }
}
