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
        Schema::table('accounts', function (Blueprint $table) {
            $table->text('note')->nullable();
            $table->integer('usr_id');
            $table->unsignedbiginteger('user_id_salary_pay')->default(0);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('accounts', function (Blueprint $table) {
            $table->DropColumn('note');
            $table->DropColumn('usr_id');
            $table->DropColumn('user_id_salary_pay');
        });
    }
};
