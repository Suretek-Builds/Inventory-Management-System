<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('procedure_template_items', static function (Blueprint $table) {
            $table->id();
            $table->integer('procedure_template_id');
            $table->foreign('procedure_template_id')->references('id')->on('procedure_templates')->onDelete('cascade');
            $table->integer('item_id');
            $table->foreign('item_id')->references('id')->on('items')->onDelete('cascade');
            $table->integer('quantity');
            $table->timestamps();
            $table->softDeletes();
        });
    }

    public function down(): void
    {
        Schema::table('procedure_template_items', static function (Blueprint $table) {
            $table->dropForeign(['procedure_template_id']);
            $table->dropForeign(['item_id']);
        });
        Schema::dropIfExists('procedure_template_items');
    }
};
