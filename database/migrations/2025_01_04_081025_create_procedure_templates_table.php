<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('procedure_templates', static function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->integer('cdt_code_id');
            $table->foreign('cdt_code_id')->references('id')->on('cdt_codes')->onDelete('cascade');
            $table->string('description')->nullable();
            $table->boolean('is_active');
            $table->timestamps();
            $table->softDeletes();
        });
    }

    public function down(): void
    {
        Schema::table('procedure_templates', static function (Blueprint $table) {
            $table->dropForeign(['cdt_code_id']);
        });
        Schema::dropIfExists('procedure_templates');
    }
};
