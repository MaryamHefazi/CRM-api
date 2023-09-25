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
        Schema::create('customers', function (Blueprint $table) {
            $table->id();

            $table->string('firstName');
            $table->string('middleName')->nullable();
            $table->string('lastName');
            $table->string('fatherName')->nullable();
            $table->unsignedBigInteger('nationalCode');
            $table->date('birthDate');
            $table->string('phoneNumber');
            $table->string('email');
            $table->string('gender')->nullable();
            $table->string('education')->nullable();
            $table->string('job')->nullable();
            $table->string('country');
            $table->string('city');
            $table->text('address');
            $table->string('password');
            $table->softDeletes();

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('customers');
    }
};
