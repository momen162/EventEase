<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void {
        Schema::create('tickets', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->cascadeOnDelete();
            $table->foreignId('event_id')->constrained()->cascadeOnDelete();
            $table->unsignedInteger('quantity')->default(1);
            $table->decimal('total_amount', 10, 2)->default(0);
            $table->enum('payment_option', ['pay_now','pay_later'])->default('pay_later');
            $table->enum('payment_status', ['paid','unpaid'])->default('unpaid');
            $table->string('ticket_code')->unique();    // e.g. TKT-ABC123
            $table->string('qr_path')->nullable();      // storage path (png) if you choose to save it
            $table->timestamps();
        });
    }
    public function down(): void {
        Schema::dropIfExists('tickets');
    }
};
