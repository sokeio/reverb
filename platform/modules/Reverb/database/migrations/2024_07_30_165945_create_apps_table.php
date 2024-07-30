<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('apps', function (Blueprint $table) {
            $table->id();
            $table->string("key")->nullable();
            $table->string("secret")->nullable();
            $table->json("options")->nullable();
            $table->json("allowed_origins")->nullable();
            $table->integer("ping_interval")->nullable()->default(60);
            $table->integer("max_message_size")->nullable()->default(10_000);
            $table->boolean("is_active")->default(1)->nullable();
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
        Schema::dropIfExists('apps');
    }
};
