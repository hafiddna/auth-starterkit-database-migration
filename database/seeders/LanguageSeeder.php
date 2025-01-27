<?php

namespace Database\Seeders;

use App\Models\Language;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class LanguageSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $languages = [
            [
                'name' => 'English (United States)',
                'code' => 'en',
                'locale' => 'en_US',
            ],
            [
                'name' => 'Indonesia',
                'code' => 'id',
                'locale' => 'id_ID',
            ],
        ];

        foreach ($languages as $language) {
            Language::create($language);
        }
    }
}
