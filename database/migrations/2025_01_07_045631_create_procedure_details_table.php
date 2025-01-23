<?php

use App\Models\Item;
use App\Models\Procedure;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('procedure_details', static function (Blueprint $table) {
            $table->id();
            $table->foreignIdFor(Procedure::class, 'procedure_id');
            $table->foreignIdFor(Item::class, 'item_id');
            $table->integer('quantity');
            $table->timestamps();
            $table->softDeletes();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('procedure_details');
    }
};
