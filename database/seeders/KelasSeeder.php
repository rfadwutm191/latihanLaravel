<?php

namespace Database\Seeders;

use App\Models\Kelas;
use Illuminate\Database\Seeder;

class KelasSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Kelas::Create(['nama_kelas' => 'Kelas A']);
        Kelas::Create(['nama_kelas' => 'Kelas B']);
        Kelas::Create(['nama_kelas' => 'Kelas C']);
    }
}
