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
            $table->string('card_no');
            $table->string('bank_name');
            $table->string('bank_title');
            $table->string('bank_logo');
            $table->string('color');
            $table->string('lighter_color');
            $table->string('darker_color');
            $table->string('iban');
            $table->string('card_regex');
            $table->string('iban_regex');
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
