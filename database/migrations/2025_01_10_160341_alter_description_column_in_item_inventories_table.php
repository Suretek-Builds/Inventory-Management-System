<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('item_inventories', static function (Blueprint $table) {
            $table->text('description')->nullable()->change();
        });
    }
};
