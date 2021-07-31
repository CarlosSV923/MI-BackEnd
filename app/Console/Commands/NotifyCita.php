<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\Personas;
use Carbon\Carbon;

class NotifyCita extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'job:notify-citas';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Job de notificacion para citas';

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
    public function handle()
    {
        $out = new \Symfony\Component\Console\Output\ConsoleOutput();
        
        $dateNow = Carbon::now()->toDateString();
        //$out->writeln(Carbon::now()->day());
        $out->writeln($dateNow . " 00:00:00");
        $dateMin = Carbon::parse($dateNow . " 00:00:00");
        $out->writeln($dateMin);
        $dateMax = Carbon::parse($dateNow . " 23:59:59");
        $out->writeln($dateMax);
        Personas::select('*')->where("inicio_cita", '', );
        return 1;
    }
}
