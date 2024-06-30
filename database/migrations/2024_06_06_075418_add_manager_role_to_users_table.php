<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddManagerRoleToUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('users', function (Blueprint $table) {
            // Tambahkan kolom 'roles' jika belum ada
            if (!Schema::hasColumn('users', 'roles')) {
                $table->enum('roles', ['admin', 'owner', 'manager'])->default('admin');
            } else {
                // Jika kolom 'roles' sudah ada, ubah tipe datanya
                DB::statement("ALTER TABLE users MODIFY roles ENUM('admin', 'owner', 'manager') NOT NULL DEFAULT 'admin'");
            }
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        // Hapus nilai 'manager' dari enum 'roles' pada tabel 'users'
        Schema::table('users', function (Blueprint $table) {
            $table->enum('roles', ['admin', 'owner'])->default('admin')->change();
        });
    }
}

