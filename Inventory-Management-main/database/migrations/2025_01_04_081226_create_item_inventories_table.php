<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('item_inventories', static function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('item_id');
            $table->foreign('item_id')->references('id')->on('items')->onDelete('cascade');
            $table->string('batch_id');
            $table->decimal('price', 10, 2);
            $table->integer('quantity');
            $table->decimal('total_cost', 15, 2);
            $table->timestamp('expire_at')->nullable();
            $table->timestamps();
            $table->softDeletes();
        });
    }

    public function down(): void
    {
        Schema::table('item_inventories', static function (Blueprint $table) {
            $table->dropForeign(['item_id']);
        });
        Schema::dropIfExists('item_inventories');
    }
};
