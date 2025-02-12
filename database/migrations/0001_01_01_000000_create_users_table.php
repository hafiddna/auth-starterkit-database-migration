<?php

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
        Schema::create('users', function (Blueprint $table) {
            $table->uuid('id')->primary()->default(DB::raw('gen_random_uuid()'));
            $table->text('email')->unique()->nullable();
            $table->unsignedBigInteger('email_verified_at')->nullable();
            $table->text('phone')->unique()->nullable();
            $table->unsignedBigInteger('phone_verified_at')->nullable();
            $table->text('username')->unique()->nullable();
            $table->text('password');
            $table->text('pin')->nullable();
            $table->text('two_factor_secret')->nullable();
            $table->text('two_factor_recovery_codes')->nullable();
            $table->unsignedBigInteger('two_factor_confirmed_at')->nullable();
            $table->boolean('is_active')->default(false);
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
        CREATE OR REPLACE FUNCTION update_created_at_jsonb_timestamps()
        RETURNS TRIGGER AS $$
        BEGIN
            NEW.metadata = jsonb_set(NEW.metadata, '{created_at}', to_jsonb((EXTRACT(EPOCH FROM NOW() AT TIME ZONE 'UTC') * 1000)::BIGINT), true);
            NEW.metadata = jsonb_set(NEW.metadata, '{updated_at}', to_jsonb((EXTRACT(EPOCH FROM NOW() AT TIME ZONE 'UTC') * 1000)::BIGINT), true);
            RETURN NEW;
        END;
        $$ LANGUAGE plpgsql;
        ");

        DB::statement("
        CREATE OR REPLACE FUNCTION update_updated_at_jsonb_timestamps()
        RETURNS TRIGGER AS $$
        BEGIN
            NEW.metadata = jsonb_set(NEW.metadata, '{updated_at}', to_jsonb((EXTRACT(EPOCH FROM NOW() AT TIME ZONE 'UTC') * 1000)::BIGINT), true);
            RETURN NEW;
        END;
        $$ LANGUAGE plpgsql;
        ");

        DB::statement("
        CREATE TRIGGER set_created_at_jsonb_timestamps
        BEFORE INSERT ON users
        FOR EACH ROW EXECUTE FUNCTION update_created_at_jsonb_timestamps();
        ");

        DB::statement("
        CREATE TRIGGER set_updated_at_jsonb_timestamps
        BEFORE UPDATE ON users
        FOR EACH ROW EXECUTE FUNCTION update_updated_at_jsonb_timestamps();
        ");

        Schema::create('password_reset_tokens', function (Blueprint $table) {
            $table->uuid('id')->primary()->default(DB::raw('gen_random_uuid()'));
            $table->foreignIdFor(User::class, 'user_id')->index()->constrained()->cascadeOnDelete();
            $table->string('contact');
            $table->string('type');
            $table->string('token');
            $table->integer('attempts')->default(0);
            $table->unsignedBigInteger('expires_at');
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
        BEFORE INSERT ON password_reset_tokens
        FOR EACH ROW EXECUTE FUNCTION update_created_at_jsonb_timestamps();
        ");

        DB::statement("
        CREATE TRIGGER set_updated_at_jsonb_timestamps
        BEFORE UPDATE ON password_reset_tokens
        FOR EACH ROW EXECUTE FUNCTION update_updated_at_jsonb_timestamps();
        ");

        Schema::create('sessions', function (Blueprint $table) {
            $table->string('id')->primary()->default(DB::raw('gen_random_uuid()'));
            $table->foreignIdFor(User::class, 'user_id')->nullable()->index()->constrained()->nullOnDelete();
            $table->string('ip_address', 45)->nullable();
            $table->text('user_agent')->nullable();
            $table->longText('payload');
            $table->unsignedBigInteger('last_activity')->index();
            $table->string('app_id')->unique();
            $table->rememberToken();
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
        BEFORE INSERT ON sessions
        FOR EACH ROW EXECUTE FUNCTION update_created_at_jsonb_timestamps();
        ");

        DB::statement("
        CREATE TRIGGER set_updated_at_jsonb_timestamps
        BEFORE UPDATE ON sessions
        FOR EACH ROW EXECUTE FUNCTION update_updated_at_jsonb_timestamps();
        ");
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        DB::statement('DROP FUNCTION IF EXISTS update_created_at_jsonb_timestamps();');
        DB::statement('DROP FUNCTION IF EXISTS update_updated_at_jsonb_timestamps();');

        Schema::dropIfExists('users');
        DB::statement('DROP TRIGGER IF EXISTS set_created_at_jsonb_timestamps ON users;');
        DB::statement('DROP TRIGGER IF EXISTS set_updated_at_jsonb_timestamps ON users;');

        Schema::dropIfExists('password_reset_tokens');
        DB::statement('DROP TRIGGER IF EXISTS set_created_at_jsonb_timestamps ON password_reset_tokens;');
        DB::statement('DROP TRIGGER IF EXISTS set_updated_at_jsonb_timestamps ON password_reset_tokens;');

        Schema::dropIfExists('sessions');
        DB::statement('DROP TRIGGER IF EXISTS set_created_at_jsonb_timestamps ON sessions;');
        DB::statement('DROP TRIGGER IF EXISTS set_updated_at_jsonb_timestamps ON sessions;');
    }
};
