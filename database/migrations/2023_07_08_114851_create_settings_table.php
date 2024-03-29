<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up(): void
    {
        Schema::create(config('settings.repositories.database.table'), function (Blueprint $table) {
            $table->id();
            $table->string('group')->nullable();
            $table->string('key');
            $table->json('payload');
            $table->nullableMorphs('settingable');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down(): void
    {
        Schema::dropIfExists(config('settings.repositories.database.table'));
    }
};
