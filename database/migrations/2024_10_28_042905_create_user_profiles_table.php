<?php

use App\Models\Asset;
use App\Models\User;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\Schema;
use MongoDB\Laravel\Schema\Blueprint;

return new class extends Migration
{
    protected $connection = 'mongodb';

    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::connection($this->connection)->dropIfExists('user_profiles');
        Schema::connection($this->connection)->create('user_profiles', function (Blueprint $collection) {
            $collection->id();
            $collection->foreignIdFor(User::class)->index()->constrained()->cascadeOnDelete();
            $collection->string('full_name');
            $collection->string('nick_name')->nullable();
            $collection->foreignIdFor(Asset::class, 'avatar_id')->nullable()->index()->constrained()->nullOnDelete();
            $collection->document('metadata', function (Blueprint $collection) {
                $collection->unsignedBigInteger('created_at');
                $collection->string('created_by');
                $collection->unsignedBigInteger('updated_at');
                $collection->string('updated_by');
                $collection->unsignedBigInteger('deleted_at')->nullable();
                $collection->string('deleted_by')->nullable();
            });
        });
    }
};
