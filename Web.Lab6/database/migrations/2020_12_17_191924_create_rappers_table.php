<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateRappersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('rappers', function (Blueprint $table) {
            $table->id();
            $table->string('name')->unique();
            $table->string('label');
            $table->string('country');
            $table->integer('dead_baddy');
            $table->float('swearing_frequency');
            $table->integer('cool_moves_count');
            $table->date('from');
            $table->enum('genre', ['freestyle', 'gangsta', 'hardcore', 'nerdcore']);
        });
    }
    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('rappers');
    }
}
