<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class PetugasSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $petugas = new petugas();
        $petugas->name = 'John Doe';
        $petugas->email = 'john@example.com';
        $petugas->password = bcrypt('password');
        $petugas->save();
    }
}
