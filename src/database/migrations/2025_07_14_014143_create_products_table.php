<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateProductsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('products', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('user_id')->nullable(); // ← after() は不要
            $table->string('name');
            $table->integer('price');
            $table->string('brand')->nullable();
            $table->text('description');
            $table->string('image_url');
            $table->string('condition');
            $table->timestamps();
            $table->boolean('is_sold')->default(false);

            // 外部キー制約は unsignedBigInteger の後に
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('products');
        Schema::table('products', function (Blueprint $table) {
            $table->dropColumn('is_sold');
        });
    }
}
