<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddTransactionDateAndTotalAmountToVendorPurchasesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('vendor_purchases', function (Blueprint $table) {
            $table->date('transaction_date')->nullable()->after('quantity');
            $table->decimal('total_amount', 15, 2)->nullable()->after('transaction_date');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('vendor_purchases', function (Blueprint $table) {
            $table->dropColumn('transaction_date');
            $table->dropColumn('total_amount');
        });
    }
}

