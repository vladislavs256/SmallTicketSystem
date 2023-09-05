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
        Schema::table('attachments', function (Blueprint $table) {
            Schema::table('attachments', function (Blueprint $table) {
                $table->string('path')->after('size'); // Add the 'path' column after 'size'
            });
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('attachments', function (Blueprint $table) {
            Schema::table('attachments', function (Blueprint $table) {
                $table->dropColumn('path'); // Remove the 'path' column if you ever need to rollback
            });
        });
    }
};
