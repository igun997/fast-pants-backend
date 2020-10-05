<?php
namespace Database\Seeders;
use Illuminate\Database\Seeder;

class UsersTableSeeder extends Seeder
{

    /**
     * Auto generated seed file
     *
     * @return void
     */
    public function run()
    {


        \DB::table('users')->delete();

        \DB::table('users')->insert(array (
            0 =>
            array (
                'id' => 1,
                'name' => 'Indra',
                'username' => 'igun997',
                'password' => '$2y$10$oxanTEl9b.0.TwnRka75zuXX70FCEkYgSXyI5BjkLcOGCt2sk9ttC',
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
        ));


    }
}
