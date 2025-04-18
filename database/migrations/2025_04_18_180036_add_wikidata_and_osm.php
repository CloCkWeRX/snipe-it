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
        Schema::table('manufacturers', function (Blueprint $table) {
            $table->string('wikidata')->nullable();
        });
        Schema::table('companies', function (Blueprint $table) {
            $table->string('wikidata')->nullable();
            $table->string('url')->nullable();
        });
        Schema::table('departments', function (Blueprint $table) {
            $table->string('wikidata')->nullable();
            $table->string('email')->nullable();
            $table->string('url')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('manufacturers', function (Blueprint $table) {
            $table->dropColumn('wikidata');
        });
        Schema::table('companies', function (Blueprint $table) {
            $table->dropColumn('wikidata');
            $table->dropColumn('url');
        });
        Schema::table('departments', function (Blueprint $table) {
            $table->dropColumn('wikidata');
            $table->dropColumn('email');
            $table->dropColumn('url');
        });
    }
};
