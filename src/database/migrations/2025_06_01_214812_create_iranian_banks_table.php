<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class () extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('iranian_banks', function (Blueprint $table) {
            $table->id();
            $table->string('card_no')->nullable()->comment('Card number');
            $table->string('bank_name')->nullable()->comment('Bank name');
            $table->string('bank_title')->nullable()->comment('Bank title');
            $table->string('bank_logo')->nullable()->comment('Bank logo URL');
            $table->string('color')->nullable()->comment('Primary color for the bank');
            $table->string('lighter_color')->nullable()->comment('Lighter shade of the bank color');
            $table->string('darker_color')->nullable()->comment('Darker shade of the bank color');
            $table->string('iban')->nullable()->comment('International Bank Account Number');
            $table->string('card_regex')->nullable()->comment('Regular expression for validating card numbers');
            $table->string('iban_regex')->nullable()->comment('Regular expression for validating IBANs');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('iranian_bank');
    }
};
