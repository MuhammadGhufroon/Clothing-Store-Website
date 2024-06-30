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
    // Nonaktifkan pengecekan kunci asing
    Schema::disableForeignKeyConstraints();

    Schema::table('deliveries', function (Blueprint $table) {
        $table->unsignedBigInteger('customer_id')->after('order_id'); // Tambah kolom customer_id setelah kolom order_id
        $table->foreign('customer_id')->references('id')->on('customers'); // Tambah foreign key ke tabel customers
    });

    // Aktifkan kembali pengecekan kunci asing
    Schema::enableForeignKeyConstraints();
}


    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('deliveries', function (Blueprint $table) {
            // Jika ingin menjalankan rollback, Anda bisa menghapus kolom dan kunci asing
            $table->dropForeign(['customer_id']);
            $table->dropColumn('customer_id');
        });
    }
};

