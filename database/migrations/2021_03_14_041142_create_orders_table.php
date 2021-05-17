<?php

use App\Models\Cart;
use App\Models\Currency;
use App\Models\Media;
use App\Models\Order;
use App\Models\Restaurant;
use App\Models\User;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateOrdersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up(): void
    {
        Schema::create('orders', function (Blueprint $table) {
            $table->id();
            $table->string('token');
            $table->foreignIdFor(User::class)->nullable();
            $table->foreignIdFor(Cart::class);
            $table->foreignIdFor(Restaurant::class);
            $table->integer('type')->default(0);
            $table->string('name')->nullable();
            $table->integer('zip')->nullable();
            $table->string('city')->nullable();
            $table->string('address')->nullable();
            $table->string('phone');
            $table->string('email');
            $table->integer('shipping_time')->default(30);
            $table->text('comment');
            $table->enum('status', Order::STATUS_LIST)->default(Order::STATUS_ORDERED);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down(): void
    {
        Schema::dropIfExists('orders');
    }
}
