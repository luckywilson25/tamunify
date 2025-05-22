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
        Schema::create('visitor_internships', function (Blueprint $table) {
            $table->id();
            $table->foreignId('visitor_id')->constrained()->onDelete('cascade');
            $table->string('institution');
            $table->date('internship_start');
            $table->date('internship_end');
            $table->enum('department', ['Produksi', 'Engineering', 'HRD', 'Keuangan', 'Marketing', 'IT', 'Lainnya']);
            $table->string('department_more')->nullable();
            $table->string('supervisor')->nullable();
            $table->string('referral_letter')->nullable();
            $table->string('emergency_contact_name');
            $table->string('emergency_contact_phone');
            $table->enum('emergency_contact_relation', ['Orang Tua', 'Sahabat', 'Kerabat', 'Pasangan', 'Lainnya']);
            $table->string('emergency_contact_relation_more')->nullable();
            $table->text('additional_info')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('visitor_internships');
    }
};