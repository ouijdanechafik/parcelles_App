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
        Schema::create('photos_identites', function (Blueprint $table) {
            $table->id();
            $table->string('src');
            $table->unsignedBigInteger('proprietaire_id');
            $table->timestamp('created_at')->useCurrent();
            //$table->timestamp('updated_at')->default(DB::raw('NULL ON UPDATE CURRENT_TIMESTAMP'))->nullable();
            $table->timestamp('updated_at')->useCurrent()->useCurrentOnUpdate();

            
            $table->softDeletes();


            $table->foreign('proprietaire_id')
            ->references('id')
            ->on('proprietaires')
            ->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('photos_identites');
    }
};
