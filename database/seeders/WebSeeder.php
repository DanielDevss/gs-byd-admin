<?php

namespace Database\Seeders;

use App\Models\Web;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Str;

class WebSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $webs = ['BYD Tepepan', 'BYD Galerías Coapa', 'BYD Cuernavaca'];

        try {
            foreach ($webs as $web) {
                Web::createOrFirst(['web' => $web], ['web' => $web, 'app_key' => Str::uuid()]);
            }
            Log::info('Webs insertadas en la base de datos.');
        } catch (\Exception $err) {
            Log::info('Algo fallo al momento de insertar las webs', [
                'context' => $err->getMessage()
            ]);
        }
    }
}
