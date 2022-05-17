<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use App\User;
use App\Siswa;
use App\Kelas;
use App\Spp;
use App\Pembayaran;

class UserTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        User::create([
            'name' => 'admin',
            'email' => 'admin@spp.com',
            'password' => Hash::make('admin'),
            'level' => 'admin',
            'created_at' => now(),
            'updated_at' => now()
        ]);

        User::create([
            'name' => 'Wawan Erwan Budiana',
            'email' => 'wawan@spp.com',
            'password' => Hash::make('password'),
            'level' => 'petugas',
            'created_at' => now(),
            'updated_at' => now()
        ]);

        Kelas::create([
            'nama_kelas' => 'X RPL',
            'kompetensi_keahlian' => 'Rekayasa Perangkat Lunak'
        ]);

        Spp::create([
            'tahun' => 2022,
            'nominal' => 200000
        ]);

        Siswa::create([
            'nisn' => '2019804089',
            'nis'  => '2019804089',
            'nama' => 'Indra Faozi',
            'id_kelas' => 1,
            'nomor_telp' => '089689957106',
            'alamat' => 'Tangerang',
            'id_spp' => 1
        ]);

        // Pembayaran::create([
        //     'id_petugas' => 2,
        //     'id_siswa' => 1,
        //     'spp_bulan' => 'februari',
        //     'jumlah_bayar' => 150000

        // ]);
    }
}
