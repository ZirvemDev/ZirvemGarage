<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('system_logs', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->nullable()->constrained()->onDelete('set null');
            $table->string('action'); // işlem tipi (login, logout, query, update vb.)
            $table->string('module'); // hangi modülde yapıldı (auth, sbm, users vb.)
            $table->text('description')->nullable(); // işlem açıklaması
            $table->json('old_data')->nullable(); // eski veri (update işlemlerinde)
            $table->json('new_data')->nullable(); // yeni veri
            $table->string('ip_address')->nullable();
            $table->string('user_agent')->nullable();
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('system_logs');
    }
}; 