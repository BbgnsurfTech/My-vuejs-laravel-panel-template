<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateIncomesTable extends Migration
{
    public function up()
    {
        Schema::create('incomes', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->date('entry_date');
            $table->decimal('amount', 15, 2);
            $table->string('description')->nullable();
            $table->timestamps();
            $table->softDeletes();
        });
    }
}
