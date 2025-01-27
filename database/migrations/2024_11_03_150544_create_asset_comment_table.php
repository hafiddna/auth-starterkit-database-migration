<?php

use App\Models\Asset;
use App\Models\User;
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
        Schema::create('asset_comment', function (Blueprint $table) {
            $table->uuid('id')->primary()->default(DB::raw('gen_random_uuid()'));
            $table->foreignIdFor(Asset::class)->constrained()->cascadeOnDelete();
            $table->foreignIdFor(User::class)->constrained()->cascadeOnDelete();
            $table->uuid('parent_id')->nullable();
            $table->text('comment');
            $table->boolean('is_resolved')->default(false);
            $table->jsonb('metadata')->default(json_encode([
                'created_at' => null,
                'created_by' => null,
                'updated_at' => null,
                'updated_by' => null,
                'deleted_at' => null,
                'deleted_by' => null
            ]));

            $table->unique(['asset_id', 'user_id']);
        });

        DB::statement('ALTER TABLE asset_comment ADD CONSTRAINT fk_asset_comment_parent_id FOREIGN KEY (parent_id) REFERENCES asset_comment(id) ON DELETE CASCADE;');

        DB::statement("
        CREATE TRIGGER set_created_at_jsonb_timestamps
        BEFORE INSERT ON asset_comment
        FOR EACH ROW EXECUTE FUNCTION update_created_at_jsonb_timestamps();
        ");

        DB::statement("
        CREATE TRIGGER set_updated_at_jsonb_timestamps
        BEFORE UPDATE ON asset_comment
        FOR EACH ROW EXECUTE FUNCTION update_updated_at_jsonb_timestamps();
        ");
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('asset_comment');
        DB::statement('DROP TRIGGER IF EXISTS set_created_at_jsonb_timestamps ON asset_comment;');
        DB::statement('DROP TRIGGER IF EXISTS set_updated_at_jsonb_timestamps ON asset_comment;');
    }
};
