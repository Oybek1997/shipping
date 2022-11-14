<?php

namespace App\Console\Commands;

use App\Vehicle;
use Illuminate\Console\Command;
use App\Warehouse;

class TenMinutesInsert extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'insertWarehouse:TenMinutes';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Insert some data in every 10 minutes';

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
        $vehicle = Vehicle::whereNull('modelname')
        // ->where('status', '!=', 9)
        // ->limit(50)
        ->get();      

        $avtomodel = [
            '13U19' => 'Lacetti',
            '1CQ48' => 'Spark',
            '1CR48' => 'Spark',
            '1EW76' => 'Tracker',
            '1EX69' => 'Tracker',
            '1EX76' => 'Tracker',
            '1EY69' => 'Tracker',
            '1EY76' => 'Tracker',
            '1JX69' => 'Cobalt',
            '1TF69' => 'Nexia R3'
        ];
        if($vehicle){
            foreach($vehicle as $v){
                $api = "https://edo-db2.uzautomotors.com/api/updatemodel/".$v->vin;
                $veh = json_decode(file_get_contents($api));
                $v->modelname =($veh && $veh[0]) ?  $avtomodel[trim($veh[0]->h06model)] : 'none';
                $v->save();
            } 
            return 'success';
        }
        return 'NOT VEHICLE';
    }
}
