<?php

use App\Models\Role;
use App\Models\Team;
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
        Schema::create('team_invitations', function (Blueprint $table) {
            $table->uuid('id')->primary()->default(DB::raw('gen_random_uuid()'));
            $table->foreignIdFor(Team::class)->constrained()->cascadeOnDelete();
            $table->string('contact');
            $table->string('type')->default('email');
            $table->string('token')->unique();
            $table->unsignedBigInteger('expires_at');
            $table->foreignIdFor(Role::class)->constrained()->cascadeOnDelete();
            $table->jsonb('metadata')->default(json_encode([
                'created_at' => null,
                'created_by' => null,
                'updated_at' => null,
                'updated_by' => null,
                'deleted_at' => null,
                'deleted_by' => null
            ]));

            $table->unique(['team_id', 'contact']);
        });

        DB::statement("
        CREATE TRIGGER set_created_at_jsonb_timestamps
        BEFORE INSERT ON team_invitations
        FOR EACH ROW EXECUTE FUNCTION update_created_at_jsonb_timestamps();
        ");

        DB::statement("
        CREATE TRIGGER set_updated_at_jsonb_timestamps
        BEFORE UPDATE ON team_invitations
        FOR EACH ROW EXECUTE FUNCTION update_updated_at_jsonb_timestamps();
        ");
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('team_invitations');
        DB::statement('DROP TRIGGER IF EXISTS set_created_at_jsonb_timestamps ON team_invitations;');
        DB::statement('DROP TRIGGER IF EXISTS set_updated_at_jsonb_timestamps ON team_invitations;');
    }
};
