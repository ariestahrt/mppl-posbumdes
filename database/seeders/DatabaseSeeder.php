<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Pegawai;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        // \App\Models\User::factory(10)->create();
        Pegawai::create(
            [
            "nama" => "Michael Alexander",
            "alamat" => "di hatimu sayang",
            "hp" => "081259787975",
            "username" => "test1",
            "password" => "password",
            ],
            [
            "nama" => "Frank Fruit",
            "alamat" => "di hatimu sayang",
            "hp" => "081259787975",
            "username" => "test2",
            "password" => "password",
            ],
        );

    }
}
