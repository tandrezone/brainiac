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
        //simple messy thing to sell at 5% gain
        $cryptos = $this->exchange->getCrypto();
        while (true) {
            $table = [];
            foreach ($cryptos->toArray() as $crypto) {
                $ticker = $this->exchange->getPrice($crypto['coin']);
                $min = $crypto['min_value'] + ($crypto['min_value'] / 100) * 5;
                $action = '';
                $gain = round(($ticker['ask'] - $crypto['min_value']) / ($crypto['min_value'] / 100), 2) . "%";
                if ($ticker['ask'] > $min) {
                    $action = 'sell';
                    print_r($this->exchange->sell($crypto['coin'], 'trade', 'sell', $crypto['value'], $ticker['ask']));
                    dd('SOLD');
                }
                $table[] = [$crypto['coin'], $crypto['min_value'], $ticker['ask'], $gain, $action];

            }
            $this->table(
                ['Coin', 'Buy Value', 'Ticker Value', 'Gain', 'Action'],
                $table
            );
            sleep(1);
        }

    }
}
