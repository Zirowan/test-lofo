<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
    {
        Schema::table('claims', function (Blueprint $table) {
            if (!Schema::hasColumn('claims', 'item_id')) {
                $table->unsignedBigInteger('item_id')->after('id');
                
                // Optional: Add foreign key constraint if needed
                $table->foreign('item_id')->references('id')->on('items')->onDelete('cascade');
            }
        });
        
        Schema::table('items', function (Blueprint $table) {
            if (!Schema::hasColumn('items', 'is_archived')) {
                $table->boolean('is_archived')->default(false)->after('selected_label');
            }
        });
    }

    public function down()
    {
        Schema::table('claims', function (Blueprint $table) {
            if (Schema::hasColumn('claims', 'item_id')) {
                $table->dropForeign(['item_id']);
                $table->dropColumn('item_id');
            }
        });
        
        Schema::table('items', function (Blueprint $table) {
            if (Schema::hasColumn('items', 'is_archived')) {
                $table->dropColumn('is_archived');
            }
        });
    }

};
