<?php

use App\Models\ItemPrice;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateItemPriceTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up(): void
    {
        Schema::create('item_prices', function (Blueprint $table) {
            $table->id();
            $table->foreignId('item_id');
            $table->foreignId('currency_id');
            $table->float('price');
            $table->enum('discount_type', ItemPrice::DISCOUNT_TYPE_LIST)->nullable();
            $table->float('discount')->default(0);
            $table->timestamps();

            $table->index(['item_id', 'currency_id']);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down(): void
    {
        Schema::dropIfExists('item_price');
    }
}
