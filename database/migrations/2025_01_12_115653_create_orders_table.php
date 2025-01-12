<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('orders', function (Blueprint $table) {
            $table->ulid('id')->primary();
            //
            $table->ulid('order_customer_id')->nullable();
            $table->ulid('ship_customer_id')->nullable();
            $table->ulid('type_flower_id')->nullable();
            $table->ulid('type_size_id')->nullable();
            $table->ulid('type_crest_id')->nullable();
            $table->ulid('store_id')->nullable();
            $table->ulid('courier_id')->nullable();
            $table->ulid('status_id')->nullable();
            $table->ulid('inputed_user_id')->nullable();
            $table->ulid('flower_image_id')->nullable();
            // 
            $table->string('code')->nullable();
            $table->timestamp('order_date')->nullable();
            $table->timestamp('ship_date')->nullable();
            $table->time('ship_time')->nullable();
            $table->text('body')->nullable();
            $table->text('request_flower_type')->nullable();
            $table->decimal('item_price', 16, 2)->nullable()->default(0);
            $table->decimal('item_qty', 16, 2)->nullable()->default(0);
            $table->text('builder_name')->nullable();
            $table->string('board_use')->nullable();
            $table->time('time_start')->nullable();
            $table->time('time_done')->nullable();
            $table->time('shiped_time')->nullable();
            //
            $table->timestamps();
            $table->softDeletes();
            $table->ulid('created_by')->nullable();
            $table->ulid('updated_by')->nullable();
            $table->ulid('deleted_by')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('orders');
    }
};
