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
        Schema::create('jobs', function (Blueprint $table) {
            $table->id();
            $table->string('title')->index();
            $table->text('description');
            $table->string('company_name')->index();
            $table->decimal('salary_min', 10, 2)->nullable()->index();
            $table->decimal('salary_max', 10, 2)->nullable()->index();
            $table->boolean('is_remote')->default(false)->index();
            $table->enum('job_type', ['full-time', 'part-time', 'contract', 'freelance'])->index();
            $table->enum('status', ['draft', 'published', 'archived'])->default('draft')->index();
            $table->timestamp('published_at')->nullable()->index();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('jobs');
    }
};
