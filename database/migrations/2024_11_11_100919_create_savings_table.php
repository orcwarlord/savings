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
        Schema::create('savings', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('description');
            $table->decimal('amount', 8, 2);
            $table->date('start_date')->nullable();
            $table->date('end_date')->nullable();
            $table->unsignedBigInteger('organisation_id');
            $table->foreign('organisation_id')->references('id')->on('organisations');
            // The saver the savings belongs to - 4 choices Martin, Alison, Michael, Ben. Include the 4 choices. Enum?
            $table->enum('saver', ['Martin', 'Alison', 'Michael', 'Ben']);
            $table->boolean('is_active')->default(true);
            $table->boolean('is_fixed')->default(false);
            $table->decimal('interest_rate', 8, 2)->nullable();
            // Transferred from another savings entry
            $table->unsignedBigInteger('transfer_id')->nullable();
            $table->foreign('transfer_id')->references('id')->on('savings');
            $table->unsignedBigInteger('type_id');
            $table->foreign('type_id')->references('id')->on('types');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('savings');
    }
};
