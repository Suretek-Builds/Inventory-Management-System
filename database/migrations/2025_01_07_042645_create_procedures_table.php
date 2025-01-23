<?php

use App\Models\CdtCode;
use App\Models\Procedure;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('procedures', static function (Blueprint $table) {
            $table->id();
            $table->string('patient_name');
            $table->string('patient_email');
            $table->string('gender', 10);
            $table->integer('age');
            $table->string('phone_number');
            $table->dateTime('procedure_date');
            $table->foreignIdFor(CdtCode::class, 'cdt_code_id');
            $table->foreignIdFor(Procedure::class, 'procedure_template_id');
            $table->timestamps();
            $table->softDeletes();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('procedures');
    }
};
