<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('sbm_queries', function (Blueprint $table) {
            $table->id();
            $table->string('location');
            $table->string('user_id');
            $table->string('plate');
            $table->dateTime('ended_date');
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('sbm_queries');
    }
};
