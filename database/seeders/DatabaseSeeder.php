<?php

namespace Database\Seeders;

use App\Models\Announcement;
use App\Models\Room;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        $pw = Hash::make('password');
        User::create(['name' => 'Pemilik Kos', 'email' => 'owner@mykost.test', 'password' => $pw, 'role' => 'owner', 'phone' => '081234567890']);
        User::create(['name' => 'Admin Kos', 'email' => 'admin@mykost.test', 'password' => $pw, 'role' => 'admin']);
        User::create(['name' => 'Budi Penghuni', 'email' => 'budi@mykost.test', 'password' => $pw, 'role' => 'penghuni', 'phone' => '081200000001']);

        $rooms = [
            ['101', 'Standar', 800000, 'Kasur, Lemari, Kipas angin', 'Kamar standar dengan kamar mandi luar.'],
            ['102', 'Standar', 850000, 'Kasur, Lemari, Meja belajar, WiFi', 'Kamar standar dengan WiFi.'],
            ['201', 'Deluxe', 1200000, 'AC, Kasur, Lemari, Kamar mandi dalam, WiFi', 'Kamar deluxe lantai 2 dengan AC.'],
            ['202', 'Deluxe', 1300000, 'AC, Water heater, Kamar mandi dalam, WiFi', 'Kamar deluxe dengan water heater.'],
        ];
        foreach ($rooms as [$n, $t, $p, $f, $d]) {
            Room::create(['number' => $n, 'type' => $t, 'price' => $p, 'facilities' => $f, 'description' => $d]);
        }

        Announcement::create(['title' => 'Selamat datang di My Kost', 'body' => 'Tagihan dibuat setiap tanggal 1 dan jatuh tempo tanggal 10.']);
    }
}
