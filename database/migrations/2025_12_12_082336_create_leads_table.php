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
        Schema::create('leads', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('phone');
            $table->string('locationlink');
            $table->text('emiratesid_path');
            $table->unsignedBigInteger('package_id');
            $table->unsignedBigInteger('user_id');
            $table->integer('status'); //0 means Submitted , 1 means In-Process , 2 means Close, 3 means Pending, 4 means Paid, 5 means Reject
            $table->timestamps();
            $table->foreign('package_id')->references('id')->on('packages');
            $table->foreign('user_id')->references('id')->on('users');
            
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('leads');
    }
};
