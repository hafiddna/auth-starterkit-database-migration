<?php

use App\Models\I18n;
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
        Schema::create('security_questions', function (Blueprint $table) {
            $table->uuid('id')->primary()->default(DB::raw('gen_random_uuid()'));
            $table->foreignIdFor(I18n::class, 'question_id')->constrained()->cascadeOnDelete();
            $table->foreignIdFor(I18n::class, 'description_id')->nullable()->constrained()->cascadeOnDelete();
            $table->jsonb('metadata')->default(json_encode([
                'created_at' => null,
                'created_by' => null,
                'updated_at' => null,
                'updated_by' => null,
                'deleted_at' => null,
                'deleted_by' => null
            ]));
        });

        DB::statement("
        CREATE TRIGGER set_created_at_jsonb_timestamps
        BEFORE INSERT ON security_questions
        FOR EACH ROW EXECUTE FUNCTION update_created_at_jsonb_timestamps();
        ");

        DB::statement("
        CREATE TRIGGER set_updated_at_jsonb_timestamps
        BEFORE UPDATE ON security_questions
        FOR EACH ROW EXECUTE FUNCTION update_updated_at_jsonb_timestamps();
        ");
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('security_questions');
        DB::statement('DROP TRIGGER IF EXISTS set_created_at_jsonb_timestamps ON security_questions;');
        DB::statement('DROP TRIGGER IF EXISTS set_updated_at_jsonb_timestamps ON security_questions;');
    }
};
