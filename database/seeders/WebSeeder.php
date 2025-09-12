<?php

namespace Database\Seeders;

use App\Models\Web;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class WebSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $webs = ['BYD Tepepan', 'BYD Galerías Coapa', 'BYD Cuernavaca'];

        foreach($webs as $web) {
            Web::create(['web' => $web]);
        }
    }
}
