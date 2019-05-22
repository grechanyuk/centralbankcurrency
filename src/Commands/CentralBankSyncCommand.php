<?php


namespace Grechanyuk\CentralBankCurrency\Commands;


use Grechanyuk\CentralBankCurrency\Utils\Currency;
use Illuminate\Console\Command;

class CentralBankSyncCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'central-bank:sync-currencies';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Sync currencies with central bank\'s server';

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
     * @return mixed
     */
    public function handle()
    {
        $c = new Currency();
        $c->updateCurrency();
    }
}