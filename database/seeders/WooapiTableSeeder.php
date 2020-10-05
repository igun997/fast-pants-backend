<?php
namespace Database\Seeders;

use Illuminate\Database\Seeder;

class WooapiTableSeeder extends Seeder
{

    /**
     * Auto generated seed file
     *
     * @return void
     */
    public function run()
    {


        \DB::table('wooapi')->delete();

        \DB::table('wooapi')->insert(array (
            0 =>
            array (
                'id' => 1,
                'name' => 'Pride N Joy',
                'domain' => 'pridenjoyco.id',
                'key_secret' => 'ck_f1fc6dbe5319f5d3a031b1538f09e576cefce05f:cs_f9d6c5923fb62e008ff97350f9e74be4827b4061',
                'user_id' => 1,
                'is_active' => 1,
                'created_at' => '2020-10-05',
                'updated_at' => '2020-10-05',
            ),
        ));


    }
}
