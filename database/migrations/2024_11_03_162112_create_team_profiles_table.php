<?php

use App\Models\Team;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    protected $connection = 'mongodb';

    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::connection($this->connection)->dropIfExists('team_profiles');
        Schema::connection($this->connection)->create('team_profiles', function (Blueprint $collection) {
            $collection->id();
            $collection->foreignIdFor(Team::class)->index()->constrained()->cascadeOnDelete();
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
