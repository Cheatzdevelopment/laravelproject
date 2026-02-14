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
        Schema::table('products', function (Blueprint $table) {
            // បន្ថែម column 'deleted_at' (timestamp nullable)
            // Column នេះចាំបាច់សម្រាប់ដំណើរការ SoftDeletes ក្នុង Model
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('products', function (Blueprint $table) {
            // លុប column 'deleted_at' ចោលវិញ ប្រសិនបើ Rollback
            $table->dropSoftDeletes();
        });
    }
};
