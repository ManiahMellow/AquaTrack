<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;

use App\Models\Batas_optimal_pH;
use App\Models\Batas_optimal_suhu;
use App\Models\Jenis_ikan;
use App\Models\pencatatan_pH;
use App\Models\pencatatan_suhu;
use App\Models\User;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // \App\Models\User::factory(10)->create();

        User::create([
            'name' => 'Masdar',
            'username' => 'masdar123',
            'password' => bcrypt('masdar123'),
            'backup_password' =>'masdar123',
            'email_Owner' => 'masdar@gmail.com',

        ]);

        User::create([
            'name' => 'Ilham',
            'username' => 'ilham123',
            'password' => bcrypt('123456'),
            'backup_password' =>'123456',
            'email_Owner' => 'ilham@gmail.com',
        ]);

    //data dummy ikan 1
    Jenis_ikan::create([
        'Jenis_Ikan' => 'nila'
    ]);

    //data dummy ikan 2
    Jenis_ikan::create([
        'Jenis_Ikan' => 'mujair'
    ]);

    //data dummy ikan 3
    Jenis_ikan::create([
        'Jenis_Ikan' => 'mas'
    ]);

    Batas_optimal_pH::create([
        'pH_Minimal' => '6',
        'pH_Maximal' => '10',
        'Jenis_ikan_ID' => 1
    ]);

    Batas_optimal_pH::create([
        'pH_Minimal' => '7',
        'pH_Maximal' => '11',
        'Jenis_ikan_ID' => 2
    ]);

    Batas_optimal_pH::create([
        'pH_Minimal' => '6',
        'pH_Maximal' => '12',
        'Jenis_ikan_ID' => 3
    ]);

    pencatatan_pH::create([
        'pH_Kolam' => 8,
        'Tanggal_Monitoring' => '2024-04-20',
        'Batas_optimal_pH_ID' => 1
    ]);

    pencatatan_pH::create([
        'pH_Kolam' => 7,
        'Tanggal_Monitoring' => '2024-04-21',
        'Batas_optimal_pH_ID' => 1
    ]);

    pencatatan_pH::create([
        'pH_Kolam' => 9,
        'Tanggal_Monitoring' => '2024-04-22',
        'Batas_optimal_pH_ID' => 1
    ]);

    pencatatan_pH::create([
        'pH_Kolam' => 6,
        'Tanggal_Monitoring' => '2024-04-23',
        'Batas_optimal_pH_ID' => 1
    ]);

    pencatatan_pH::create([
        'pH_Kolam' => 7,
        'Tanggal_Monitoring' => '2024-04-24',
        'Batas_optimal_pH_ID' => 1
    ]);

    pencatatan_pH::create([
        'pH_Kolam' => 9,
        'Tanggal_Monitoring' => '2024-04-25',
        'Batas_optimal_pH_ID' => 1
    ]);

    pencatatan_pH::create([
        'pH_Kolam' => 7,
        'Tanggal_Monitoring' => '2024-04-26',
        'Batas_optimal_pH_ID' => 1
    ]);

    Batas_optimal_suhu::create([
        'Suhu_Minimal' => 34,
        'Suhu_Maximal' => 38,
        'Jenis_ikan_ID' => 1
    ]);
    Batas_optimal_suhu::create([
        'Suhu_Minimal' => 33,
        'Suhu_Maximal' => 37,
        'Jenis_ikan_ID' => 2
    ]);
    Batas_optimal_suhu::create([
        'Suhu_Minimal' => 32,
        'Suhu_Maximal' => 35,
        'Jenis_ikan_ID' => 3
    ]);

    pencatatan_suhu::create([
        'suhu_Kolam' => 34,
        'Tanggal_Monitoring' => '2024-04-20',
        'Batas_optimal_suhu_ID' =>1
    ]);

    pencatatan_suhu::create([
        'suhu_Kolam' => 35,
        'Tanggal_Monitoring' => '2024-04-21',
        'Batas_optimal_suhu_ID' =>1
    ]);

    pencatatan_suhu::create([
        'suhu_Kolam' => 33,
        'Tanggal_Monitoring' => '2024-04-22',
        'Batas_optimal_suhu_ID' =>1
    ]);

    pencatatan_suhu::create([
        'suhu_Kolam' => 34,
        'Tanggal_Monitoring' => '2024-04-23',
        'Batas_optimal_suhu_ID' =>1
    ]);

    pencatatan_suhu::create([
        'suhu_Kolam' => 36,
        'Tanggal_Monitoring' => '2024-04-24',
        'Batas_optimal_suhu_ID' =>1
    ]);

    pencatatan_suhu::create([
        'suhu_Kolam' => 35,
        'Tanggal_Monitoring' => '2024-04-25',
        'Batas_optimal_suhu_ID' =>1
    ]);

    pencatatan_suhu::create([
        'suhu_Kolam' => 34,
        'Tanggal_Monitoring' => '2024-04-26',
        'Batas_optimal_suhu_ID' =>1
    ]);
     }
}
