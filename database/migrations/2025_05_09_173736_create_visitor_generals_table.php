<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('visitor_generals', function (Blueprint $table) {
            $table->id();
            $table->foreignId('visitor_id')->constrained()->onDelete('cascade');
            $table->string('company')->nullable();
            $table->enum('purpose', ['Rapat / Meeting', 'Pengiriman / Delivery', 'Maintenance', 'Interview', 'Lainnya']);
            $table->string('purpose_more')->nullable();
            $table->string('person_to_meet');
            $table->enum('department', ['Produksi', 'Engineering', 'HRD', 'Keuangan', 'Marketing', 'IT', 'Lainnya']);
            $table->string('department_more')->nullable();
            $table->date('visit_date');
            $table->date('exit_date');
            $table->time('visit_time');
            $table->time('exit_time');
            $table->string('vehicle_number')->nullable();
            $table->text('additional_info')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('visitor_generals');
    }
};