<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {

        Schema::create('roles', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('slug');
            $table->timestamps();
        });

        // Tabel teachers
        Schema::create('teachers', function (Blueprint $table) {
            $table->id('teacher_id');
            $table->integer('nip')->unique();
            $table->unsignedBigInteger('role_id');
            $table->foreign('role_id')->references('id')->on('roles');
            $table->string('name');
            $table->string('barcode')->unique();
            $table->timestamps();
        });

        // Tabel shifts
        Schema::create('shifts', function (Blueprint $table) {
            $table->id('shift_id');
            $table->string('shift_name');
            $table->timestamp('start_time')->nullable();
            $table->timestamp('end_time')->nullable();
            $table->timestamps();
        });

        // Tabel attendances
        Schema::create('attendances', function (Blueprint $table) {
            $table->id('attendance_id');
            $table->unsignedBigInteger('teacher_id');
            $table->foreign('teacher_id')->references('teacher_id')->on('teachers');
            $table->timestamp('hour_came')->nullable();
            $table->timestamp('home_time')->nullable();
            $table->string('barcode');
            $table->decimal('overtime_hours', 5, 2)->nullable();
            $table->enum('status', ['Hadir', 'Sakit', 'Alpa', 'Izin'])->default('Hadir');
            $table->timestamps();
        });

        // Tabel barcode_scans
        Schema::create('barcode_scans', function (Blueprint $table) {
            $table->string('barcode')->primary();
            $table->timestamp('scan_timestamp');
            $table->timestamps();
        });



        // // Tabel public_holidays
        // Schema::create('public_holidays', function (Blueprint $table) {
        //     $table->id();
        //     $table->date('holiday_date');
        //     $table->string('holiday_name');
        //     $table->timestamps();
        // });

        // // Tabel custom_working_days
        // Schema::create('custom_working_days', function (Blueprint $table) {
        //     $table->id();
        //     $table->string('day_name');
        //     $table->timestamps();
        // });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('custom_working_days');
        Schema::dropIfExists('public_holidays');
        Schema::dropIfExists('shifts');
        Schema::dropIfExists('barcode_scans');
        Schema::dropIfExists('locations');
        Schema::dropIfExists('attendances');
        Schema::dropIfExists('teachers');
    }
};