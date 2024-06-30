<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
{
    Schema::table('wishlists', function (Blueprint $table) {
        $table->string('selected_image')->nullable();
    });

    Schema::table('order_details', function (Blueprint $table) {
        $table->string('selected_image')->nullable();
    });
}

public function down()
{
    Schema::table('wishlists', function (Blueprint $table) {
        $table->dropColumn('selected_image');
    });

    Schema::table('order_details', function (Blueprint $table) {
        $table->dropColumn('selected_image');
    });
}

};
