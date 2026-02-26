<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddProfileColumnsToUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('users', function (Blueprint $table) {
            $table->string('postcode', 8)->nullable()->after('name');
            $table->string('address')->nullable()->after('postcode');
            $table->string('building_name')->nullable()->after('address');
            $table->string('profile_image')->nullable()->after('building_name');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn([
                'postcode',
                'address',
                'building_name',
                'profile_image',
            ]);
        });
    }
}
