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
        Schema::create('syncdata', function (Blueprint $table) {
            $table->id();
            $table->string('nama_api', 255);
            $table->string('route_sync', 255)->nullable();
            $table->timestamp('last_synced_at')->nullable();
            $table->timestamps();
        });

        DB::table('syncdata')->insert([
            [
                'nama_api' => 'Sync Penyedia',
                'route_sync' => 'syncpenyedia',
                'last_synced_at' => null,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'nama_api' => 'Sync Tender',
                'route_sync' => 'synctender',
                'last_synced_at' => null,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'nama_api' => 'Sync Non Tender',
                'route_sync' => 'syncnontender',
                'last_synced_at' => null,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'nama_api' => 'Sync Kontrak Tender',
                'route_sync' => 'synckontraktender',
                'last_synced_at' => null,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'nama_api' => 'Sync Kontrak Non Tender',
                'route_sync' => 'synckontraknontender',
                'last_synced_at' => null,
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ]);
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('syncdata');
    }
};
