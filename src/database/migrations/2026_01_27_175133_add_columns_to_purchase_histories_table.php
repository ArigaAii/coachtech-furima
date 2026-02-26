<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddColumnsToPurchaseHistoriesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up(): void
    {
        Schema::table('purchase_histories', function (Blueprint $table) {
            $table->string('postcode')->nullable()->after('item_id');
            $table->string('address')->nullable()->after('postcode');
            $table->string('building_name')->nullable()->after('address');

            $table->string('payment_method')->nullable()->after('building_name'); // 'card' etc
            $table->string('status')->default('purchased')->after('payment_method'); // draft/purchased など
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down(): void
    {
        Schema::table('purchase_histories', function (Blueprint $table) {
            $table->dropColumn(['postcode','address','building_name','payment_method','status']);
        });
    }
}
