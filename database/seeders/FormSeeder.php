<?php

namespace Database\Seeders;

use App\Models\Form;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Log;

class FormSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $forms = [
            ['key' => 'quote', 'label' => 'Cotización de modelo'],
            ['key' => 'quote-version', 'label' => 'Cotización de versión por modelo'],
            ['key' => 'drive', 'label' => 'Agendar prueba de manejo'],
            ['key' => 'contact', 'label' => 'Contacto de prospectos'],
            ['key' => 'service', 'label' => 'Informes de servicios'],
        ];

        try {
            foreach ($forms as $form) {
                Form::updateOrCreate(['key' => $form['key']], $form);
            }
            Log::info('Se insertarón los formularios en la base de datos.');
        } catch (\Exception $err) {
            Log::error('Algo fallo al momento de insertar los formularios', [
                'error' => $err->getMessage()
            ]);
        }
    }
}
