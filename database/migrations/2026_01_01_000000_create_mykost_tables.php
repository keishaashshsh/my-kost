<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::table('users', function (Blueprint $t) {
            $t->string('role')->default('penghuni'); // owner, admin, penghuni
            $t->string('phone')->nullable();
        });

        Schema::create('rooms', function (Blueprint $t) {
            $t->id();
            $t->string('number')->unique();
            $t->string('type');
            $t->unsignedInteger('price');
            $t->string('facilities')->nullable();
            $t->text('description')->nullable();
            $t->string('photo')->nullable();
            $t->string('status')->default('kosong'); // kosong, terisi
            $t->timestamps();
        });

        Schema::create('bookings', function (Blueprint $t) {
            $t->id();
            $t->foreignId('user_id')->constrained()->cascadeOnDelete();
            $t->foreignId('room_id')->constrained()->cascadeOnDelete();
            $t->date('start_date');
            $t->text('note')->nullable();
            $t->string('status')->default('menunggu'); // menunggu, dikonfirmasi, ditolak
            $t->timestamps();
        });

        Schema::create('contracts', function (Blueprint $t) {
            $t->id();
            $t->foreignId('user_id')->constrained()->cascadeOnDelete();
            $t->foreignId('room_id')->constrained()->cascadeOnDelete();
            $t->date('start_date');
            $t->date('end_date');
            $t->string('status')->default('aktif'); // aktif, selesai
            $t->timestamps();
        });

        Schema::create('bills', function (Blueprint $t) {
            $t->id();
            $t->foreignId('contract_id')->constrained()->cascadeOnDelete();
            $t->string('period'); // format Y-m
            $t->unsignedInteger('rent');
            $t->unsignedInteger('elec_kwh')->default(0);
            $t->unsignedInteger('water_m3')->default(0);
            $t->unsignedInteger('total');
            $t->date('due_date');
            $t->string('status')->default('belum'); // belum, menunggu, lunas
            $t->string('proof')->nullable();
            $t->timestamp('paid_at')->nullable();
            $t->string('receipt_no')->nullable();
            $t->timestamps();
            $t->unique(['contract_id', 'period']);
        });

        Schema::create('complaints', function (Blueprint $t) {
            $t->id();
            $t->foreignId('user_id')->constrained()->cascadeOnDelete();
            $t->string('title');
            $t->text('body');
            $t->string('photo')->nullable();
            $t->string('status')->default('diterima'); // diterima, diproses, selesai
            $t->timestamps();
        });

        Schema::create('announcements', function (Blueprint $t) {
            $t->id();
            $t->string('title');
            $t->text('body');
            $t->timestamps();
        });
    }

    public function down(): void
    {
        foreach (['announcements', 'complaints', 'bills', 'contracts', 'bookings', 'rooms'] as $tbl) {
            Schema::dropIfExists($tbl);
        }
        Schema::table('users', fn (Blueprint $t) => $t->dropColumn(['role', 'phone']));
    }
};
