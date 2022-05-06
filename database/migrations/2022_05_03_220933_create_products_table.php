<?php

use App\Models\User;
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
        Schema::create('products', function (Blueprint $table) {
            $table->id();
            $table->timestamps();
            $table->string('product_name');
            $table->text('description')->nullable();
            $table->text('style');
            $table->text('brand');
            $table->string('url')->nullable();
            $table->string('product_type');
            $table->integer('shipping_price');
            $table->text('note')->nullable();
            $table->foreignIdFor(User::class, 'user_id');

            $table->index('product_name');
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
    }
};
