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
    }

    public function init() {
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

    public function getCrypto() {
        return Balance::where('coin','!=','USD')->where('value','!=',0)->get();
    }

    public function fetch_open_orders() {
        $orders = $this->exchange->fetch_open_orders();
        return $orders;
    }

    public function getPrice($symbol) {
        return $this->exchange->fetch_ticker($symbol."/USD");
    }

    public function sell($symbol, $type, $side, $amount, $price ) {
        return $this->exchange->create_order($symbol."/USD", $type, $side, $amount, $price);
    }
}
