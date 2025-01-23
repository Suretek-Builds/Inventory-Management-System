<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('item_inventories', static function (Blueprint $table) {
            $table->string('type');
            $table->integer('procedure_id')->nullable();
            $table->string('description')->nullable();
            $table->string('batch_id')->nullable()->change();
            $table->dropColumn('price');
            $table->dropColumn('total_cost');
        });
    }

    public function down(): void
    {
        Schema::table('item_inventories', function (Blueprint $table) {
            //
        });
    }
};
