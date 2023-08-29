<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('admin_menu', function (Blueprint $table) {
            //
            $table->string('module', 100)->default('admin');
        });
        Schema::table('admin_menu', function (Blueprint $table) {
            //
            $table->string('module', 100)->change();
        });


    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('admin_menu', function (Blueprint $table) {
            //
            $table->dropColumn('module');
        });
    }
};
