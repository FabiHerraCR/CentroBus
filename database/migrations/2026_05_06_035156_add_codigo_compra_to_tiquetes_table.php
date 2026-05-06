<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('tiquetes', function (Blueprint $table) {
            $table->string('codigo_compra')->nullable()->after('codigo')->index();
        });

        DB::table('tiquetes')
            ->whereNull('codigo_compra')
            ->update([
                'codigo_compra' => DB::raw('codigo'),
            ]);
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('tiquetes', function (Blueprint $table) {
            $table->dropIndex(['codigo_compra']);
            $table->dropColumn('codigo_compra');
        });
    }
};
