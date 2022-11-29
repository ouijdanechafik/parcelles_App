<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('parcelles', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('user_id');
            $table->unsignedBigInteger('proprietaire_id');
            $table->bigInteger('numero')->unique();
            $table->date('date_delimation');
            $table->unsignedBigInteger('village_id');
            $table->string('signature');

            $table->foreign('user_id')
                ->references('id')
                ->on('users')
                ->onDelete('cascade');

            $table->foreign('proprietaire_id')
                ->references('id')
                ->on('proprietaires')
                ->onDelete('cascade');

            $table->foreign('village_id')
                ->references('id')
                ->on('villages')
                ->onDelete('cascade');

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('parcelles');
    }
};
