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
//        Schema::create('cache', function (Blueprint $table) {
//            $table->uuid('id')->primary()->default(DB::raw('gen_random_uuid()'));
//            $table->string('key')->unique();
//            $table->mediumText('value');
//            $table->integer('expiration');
//            $table->jsonb('metadata')->default(json_encode([
//                'created_at' => null,
//                'created_by' => null,
//                'updated_at' => null,
//                'updated_by' => null,
//                'deleted_at' => null,
//                'deleted_by' => null
//            ]));
//        });
//
//        DB::statement("
//        CREATE TRIGGER set_created_at_jsonb_timestamps
//        BEFORE INSERT ON cache
//        FOR EACH ROW EXECUTE FUNCTION update_created_at_jsonb_timestamps();
//        ");
//
//        DB::statement("
//        CREATE TRIGGER set_updated_at_jsonb_timestamps
//        BEFORE UPDATE ON cache
//        FOR EACH ROW EXECUTE FUNCTION update_updated_at_jsonb_timestamps();
//        ");
//
//        Schema::create('cache_locks', function (Blueprint $table) {
//            $table->uuid('id')->primary()->default(DB::raw('gen_random_uuid()'));
//            $table->string('key')->unique();
//            $table->string('owner');
//            $table->integer('expiration');
//            $table->jsonb('metadata')->default(json_encode([
//                'created_at' => null,
//                'created_by' => null,
//                'updated_at' => null,
//                'updated_by' => null,
//                'deleted_at' => null,
//                'deleted_by' => null
//            ]));
//        });
//
//        DB::statement("
//        CREATE TRIGGER set_created_at_jsonb_timestamps
//        BEFORE INSERT ON cache_locks
//        FOR EACH ROW EXECUTE FUNCTION update_created_at_jsonb_timestamps();
//        ");
//
//        DB::statement("
//        CREATE TRIGGER set_updated_at_jsonb_timestamps
//        BEFORE UPDATE ON cache_locks
//        FOR EACH ROW EXECUTE FUNCTION update_updated_at_jsonb_timestamps();
//        ");
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
//        Schema::dropIfExists('cache');
//        DB::statement('DROP TRIGGER IF EXISTS set_created_at_jsonb_timestamps ON cache;');
//        DB::statement('DROP TRIGGER IF EXISTS set_updated_at_jsonb_timestamps ON cache;');
//
//        Schema::dropIfExists('cache_locks');
//        DB::statement('DROP TRIGGER IF EXISTS set_created_at_jsonb_timestamps ON cache_locks;');
//        DB::statement('DROP TRIGGER IF EXISTS set_updated_at_jsonb_timestamps ON cache_locks;');
    }
};
