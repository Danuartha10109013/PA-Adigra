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
        Schema::table('users', function (Blueprint $table) {
            $table->integer('kompetensi_teknis')->default(0)->nullable();
            $table->integer('kedisiplinan')->default(0)->nullable();
            $table->integer('sikap')->default(0)->nullable();
            $table->integer('produktivitas')->default(0)->nullable();
            $table->integer('kreativitas')->default(0)->nullable();
            $table->integer('kerjasama')->default(0)->nullable();
            $table->integer('komunikasi')->default(0)->nullable();
            $table->integer('nilai_akhir')->default(0)->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn('kompetensi_teknis');
            $table->dropColumn('kedisiplinan');
            $table->dropColumn('sikap');
            $table->dropColumn('produktivitas');
            $table->dropColumn('kreativitas');
            $table->dropColumn('kerjasama');
            $table->dropColumn('komunikasi');
            $table->dropColumn('nilai_akhir');
        });
    }
};
