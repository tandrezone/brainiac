<?php

namespace App\Console\Commands;

use App\Services\ExchangeService;
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
        //dd("x");
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

/**
        $balance = $this->exchange->getBalance();
        $trades = $this->exchange->fetch_my_trades();
        $freeCoins = [];
        $total = 0;
        foreach($balance['free'] as $symbol=>$value) {
            if($value != 0) {
                $price = 1;
                if($symbol != "USD")  {
                    $ticker = $this->exchange->fetch_ticker($symbol."/USD");
                    $price = $ticker['ask'];
                }
                $value_in_usd = $value*$price;
                $freeCoins[] = [$symbol, $value, $value_in_usd, $price];
                $total+=round($value_in_usd,2);
            }
        }

        //$trades = $this->exchange->fetch_my_trades();
        //save trades to debug later

        $this->table(
            ['Symbol','Value','In USD','Price per coin'],
            $freeCoins
        );
        $this->line('Total: '.$total);
        return Command::SUCCESS;
 * **/
    }
}
