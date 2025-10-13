<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up()
    {
        // Add unique index to email column if it doesn't exist
        Schema::table('students', function (Blueprint $table) {
            if (!Schema::hasIndex('students', 'students_email_unique')) {
                $table->unique('email');
            }
        });
        
        Schema::table('claims', function (Blueprint $table) {
            // Drop existing columns if they exist
            if (Schema::hasColumn('claims', 'claimed_by')) {
                $table->dropColumn('claimed_by');
            }
            if (Schema::hasColumn('claims', 'claimed_to')) {
                $table->dropColumn('claimed_to');
            }

            // Add new string email-based columns
            $table->string('claimed_by')->after('id');
            $table->string('claimed_to')->after('claimed_by');

            // Add foreign key constraints referencing student emails
            $table->foreign('claimed_by')->references('email')->on('students')->onDelete('cascade');
            $table->foreign('claimed_to')->references('email')->on('students')->onDelete('cascade');
        });
    }

    public function down()
    {
        Schema::table('claims', function (Blueprint $table) {
            $table->dropForeign(['claimed_by']);
            $table->dropForeign(['claimed_to']);
            $table->dropColumn(['claimed_by', 'claimed_to']);
        });
    }
};
