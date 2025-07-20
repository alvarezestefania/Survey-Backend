<?php
namespace Database\Seeders;

use App\Enums\QuestionType;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;


class QuestionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('survey_questions')->insert([
            'description' => '¿Cuál considera que es el mayor reto en su labor diaria dentro de la droguería?',
            'type'        => QuestionType::Text->value,
            'options'     => null,
        ]);

        DB::table('survey_questions')->insert([
            'description' => '¿Con qué frecuencia realiza control de inventario en su droguería?',
            'type'        => QuestionType::Radio->value,
            'options'     => json_encode(['A diario', 'Semanalmente', 'Quincenalmente', 'Rara vez']),
        ]);

        DB::table('survey_questions')->insert([
            'description' => '¿Qué tan fácil considera que es utilizar su sistema actual de facturación?',
            'type'        => QuestionType::Range->value,
            'options'     => json_encode([
                'min'    => 1,
                'max'    => 10,
                'labels' => [
                    '1'  => 'Muy difícil',
                    '10' => 'Muy fácil',
                ],
            ]),
        ]);

        DB::table('survey_questions')->insert([
            'description' => 'En promedio, ¿cuántos productos vende al día?',
            'type'        => QuestionType::Number->value,
            'options'     => null,

        ]);

        DB::table('survey_questions')->insert([
            'description' => '¿Qué herramientas utiliza actualmente en su labor? (Puede seleccionar varias opciones)',
            'type'        => QuestionType::Checkbox->value,
            'options'     => json_encode([
                'Software de facturación',
                'Hojas de cálculo (Excel, Google Sheets)',
                'Registros físicos (cuadernos, libretas)',
                'Lectores de código de barras',
                'No utilizo herramientas digitales']),
        ]);

        DB::table('survey_questions')->insert([
            'description' => '¿Cuál es su ciudad de trabajo principal?',
            'type'        => QuestionType::Select->value,
            'options'     => json_encode([
                'Bogotá',
                'Medellín',
                'Cali',
                'Barranquilla',
                'Otra',
            ]),
        ]);
    }
}
