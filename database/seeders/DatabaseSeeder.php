<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Teacher;
use App\Models\Attendance;
use App\Models\Location;
use App\Models\BarcodeScan;
use Carbon\Carbon;
use Ramsey\Uuid\Uuid;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $this->call(TeachersTableSeeder::class);
        $this->call(ShiftsTableSeeder::class);
        $this->call(BarcodeScansTableSeeder::class);
        $this->call(AttendancesTableSeeder::class);
    }
}

class TeachersTableSeeder extends Seeder
{

    public function run()
    {
        DB::table('roles')->insert([
            'name' => 'Admin',
            'slug' => 'admin',

        ]);

        DB::table('teachers')->insert([
            'nip' => '1234566',
            'name' => 'John Doe',
            'barcode' => '123456',
            'role_id' => 1,
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now(),
        ]);

        DB::table('users')->insert([
            'name' => 'admin',
            'email' => 'admin@gmail.com',
            'password' => Hash::make('admin'),
        ]);
    }
}

class ShiftsTableSeeder extends Seeder
{
    public function run()
    {
        DB::table('shifts')->insert([
            'shift_name' => 'Morning Shift',
            'start_time' => '2023-06-15 08:00:00',
            'end_time' => '2023-06-15 16:00:00',
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now(),
        ]);
    }
}

class BarcodeScansTableSeeder extends Seeder
{
    public function run()
    {
        DB::table('barcode_scans')->insert([
            'barcode' => '123456',
            'scan_timestamp' => Carbon::now(),
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now(),
        ]);
    }
}

class AttendancesTableSeeder extends Seeder
{
    public function run()
    {
        DB::table('attendances')->insert([
            'teacher_id' => 1,
            'hour_came' => Carbon::now(),
            'home_time' => Carbon::now()->addHours(8),
            'barcode' => '123456',
            'overtime_hours' => 2.5,
            'status' => 'Hadir',
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now(),
        ]);
    }
}