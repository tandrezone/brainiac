<?php

namespace App\Services;

use App\Models\Balance;
use App\Models\Trade;
use ccxt\bitstamp;

class ExchangeService
{
    private $exchange;

    public function __construct()
    {
        $this->exchange = new bitstamp(array(
            'apiKey' => env("API_KEY"),
            'secret' => env('API_SECRET'),
        ));
        $this->setBalance();
        $this->setTrades();
    }

    private function setBalance() {
        $balance = $this->exchange->fetch_balance();
        foreach ($balance['free'] as $coin=>$value) {
            Balance::updateOrCreate([
                'coin' => $coin,
                'value' => $value,
            ]);
        }
    }

    private function setTrades() {
        $trades = $this->exchange->fetch_my_trades();
        foreach ($trades as $trade) {
            Trade::create([
                'symbol' => $trade['symbol'],
                'side' => $trade['side'],
                'price' => $trade['price'],
                'amount' => $trade['amount'],
                'cost' => $trade['cost'],
                'fee' => $trade['fee']['cost'],
                'fee_currency' => $trade['fee']['currency'],
            ]);
        }
    }

    public function getBalance() {
        return Balance::all()->toArray();
    }

}
