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
        Schema::create('stores', function (Blueprint $table) {
            $table->string("slug")->unique();
            $table->string("user_id");
            $table->string("name");
            $table->string("owner");
            $table->bigInteger("nik")->unique();
            $table->string("address");
            $table->string("coordinate");
            $table->string("ktp")->nullable();
            $table->string("siu")->nullable();
            $table->string("img_owner")->nullable();
            $table->string("img_store")->nullable();
            $table->string("status");
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
        Schema::dropIfExists('stores');
    }
};
