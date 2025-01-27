<?php

use App\Models\Asset;
use Database\Seeders\LanguageSeeder;
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
        Schema::create('languages', function (Blueprint $table) {
            $table->uuid('id')->primary()->default(DB::raw('gen_random_uuid()'));
            $table->string('name');
            $table->string('code');
            $table->string('locale')->unique()->index();
            $table->boolean('is_rtl')->default(false);
            $table->foreignIdFor(Asset::class, 'icon_id')->nullable()->constrained()->nullOnDelete();
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
        BEFORE INSERT ON languages
        FOR EACH ROW EXECUTE FUNCTION update_created_at_jsonb_timestamps();
        ");

        DB::statement("
        CREATE TRIGGER set_updated_at_jsonb_timestamps
        BEFORE UPDATE ON languages
        FOR EACH ROW EXECUTE FUNCTION update_updated_at_jsonb_timestamps();
        ");

        $languageSeeder = new LanguageSeeder();
        $languageSeeder->run();
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('languages');
        DB::statement('DROP TRIGGER IF EXISTS set_created_at_jsonb_timestamps ON languages;');
        DB::statement('DROP TRIGGER IF EXISTS set_updated_at_jsonb_timestamps ON languages;');
    }
};
