<?php

use App\Models\SecurityQuestion;
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
        Schema::create('user_security_answers', function (Blueprint $table) {
            $table->uuid('id')->primary()->default(DB::raw('gen_random_uuid()'));
            $table->foreignIdFor(User::class)->constrained()->cascadeOnDelete();
            $table->foreignIdFor(SecurityQuestion::class)->constrained()->cascadeOnDelete();
            $table->text('answer');
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
        BEFORE INSERT ON user_security_answers
        FOR EACH ROW EXECUTE FUNCTION update_created_at_jsonb_timestamps();
        ");

        DB::statement("
        CREATE TRIGGER set_updated_at_jsonb_timestamps
        BEFORE UPDATE ON user_security_answers
        FOR EACH ROW EXECUTE FUNCTION update_updated_at_jsonb_timestamps();
        ");
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('user_security_answers');
        DB::statement('DROP TRIGGER IF EXISTS set_created_at_jsonb_timestamps ON user_security_answers;');
        DB::statement('DROP TRIGGER IF EXISTS set_updated_at_jsonb_timestamps ON user_security_answers;');
    }
};
