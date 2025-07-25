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
        Schema::table('leave_quotas', function (Blueprint $table) {
            $table->year('year')->after('user_id')->default(date('Y'));
            $table->string('month')->nullable()->change();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('leave_quotas', function (Blueprint $table) {
            $table->dropColumn('year');
            $table->string('month')->nullable(false)->change();
        });
    }
};
