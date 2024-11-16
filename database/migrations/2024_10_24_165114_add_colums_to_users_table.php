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
            $table->unsignedBigInteger('role_id')->after('remember_token')->nullable();
            $table->foreign('role_id')->references('id')->onDelete('set null')->on('roles');
            $table->text('address')->after('role_id')->nullable();
            $table->string('gender')->after('address')->nullable();
            $table->string('religion')->after('gender')->nullable();
            $table->string('foto')->after('religion')->nullable();
            $table->string('no_hp')->nullable();
            $table->string('place_birth')->after('religion')->nullable();
            $table->string('date_birth')->after('place_birth')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropForeign(['role_id']);
            $table->dropColumn(['role_id', 'address', 'gender', 'religion', 'foto', 'no_hp', 'place_birth', 'date_birth']);
        });
    }
};
