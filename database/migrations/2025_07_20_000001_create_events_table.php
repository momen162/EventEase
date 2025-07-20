<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        if (!Schema::hasTable('events')) {
            Schema::create('events', function (Blueprint $table) {
                $table->bigIncrements('id');
                $table->timestamps();
            });
        }
    }

    public function down(): void
    {
        if (Schema::hasTable('events')) {
            Schema::drop('events');
        }
    }
};
