<?php

namespace Modules\Fleet\Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Database\Eloquent\Model;

class ZapierTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Model::unguard();
        $sub_module = [
            'New Driver', 'New Customer', 'New Vehicle', 'New Booking', 'New Fleet Payment'
        ];

        foreach($sub_module as $sm){
            $check = \Modules\Zapier\Entities\ZapierModule::where('module','Fleet')->where('submodule',$sm)->first();
            if(!$check){
                $new = new \Modules\Zapier\Entities\ZapierModule();
                $new->module = 'Fleet';
                $new->submodule = $sm;
                $new->save();
            }
        }
        // $this->call("OthersTableSeeder");
    }
}
