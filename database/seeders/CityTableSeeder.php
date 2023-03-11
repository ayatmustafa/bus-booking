<?php

namespace Database\Seeders;

use App\Models\City;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class CityTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $data = [
            array('name' => "Aswan"),
            array('name' => "Qina"),
            array('name' => "Sawhaj"),
            array('name' => "Asyut"),
            array('name' => "AlMinya"),
            array('name' => "Bani Suwayf"),
            array('name' => "al-Fayyum"),
            array('name' => "Giza"),
            array('name' => "Cairo"),
            array('name' => "al-Fayyum"),
            array('name' => "Bur Sa'id"),
            array('name' => "Dumyat"),
            array('name' => "Kafr-ash-Shaykh"),
            array('name' => "Matruh"),
            array('name' => "Muhafazat ad Daqahliyah"),
            array('name' => "Muhafazat al Fayyum"),
            array('name' => "Muhafazat al Gharbiyah"),
            array('name' => "Muhafazat al Iskandariyah"),
            array('name' => "Muhafazat al Qahirah"),
            array('name' => "Sina al-Janubiyah"),
            array('name' => "Sina ash-Shamaliyah"),
            array('name' => "ad-Daqahliyah"),
            array('name' => "al-Bahr-al-Ahmar"),
            array('name' => "al-Buhayrah"),
            array('name' => "al-Gharbiyah"),
            array('name' => "al-Iskandariyah"),
            array('name' => "al-Ismailiyah"),
            array('name' => "al-Jizah"),
            array('name' => "al-Minufiyah"),
            array('name' => "al-Minya"),
            array('name' => "al-Qahira"),
            array('name' => "al-Qalyubiyah"),
            array('name' => "al-Uqsur"),
            array('name' => "al-Wadi al-Jadid"),
            array('name' => "as-Suways"),
            array('name' => "ash-Sharqiyah"),
            array('name' => "Ahuachapan"),
        ];

        City::insert($data);
    }
}
