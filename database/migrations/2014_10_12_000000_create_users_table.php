<?php

use Carbon\Carbon;
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
        Schema::create('users', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('email')->unique();
            $table->timestamp('email_verified_at')->nullable();
            $table->string('password');
            $table->boolean('superadmin')->default(false);
            $table->string('shop_name')->default('');
            $table->string('card_brand')->default('');
            $table->string('card_last_four')->default('');
            $table->timestamp('trial_starts_at')->default(Carbon::now());
            $table->timestamp('trial_ends_at')->default(Carbon::now()->addDays(14));
            $table->string('shop_domain')->default('');
            $table->boolean('is_enabled')->default(true);
            $table->string('billing_plan')->default('');
            $table->rememberToken();
            $table->foreignId('current_team_id')->nullable();
            $table->string('profile_photo_path', 2048)->nullable();
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
        Schema::dropIfExists('users');
    }
};
