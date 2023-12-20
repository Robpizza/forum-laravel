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
        Schema::create('system_translations', function (Blueprint $table) {
            $table->id('translation_id');
            $table->string('translation_group', 255);
            $table->string('translation_key', 255);
            $table->longText('translation_text');
            $table->timestamp('translation_createdate')->useCurrent();
            $table->timestamp('translation_changedate')->useCurrent()->useCurrentOnUpdate();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('system_translations');
    }
};
