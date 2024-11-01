<?php

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
        Schema::connection($this->connection)->dropIfExists('user_settings');
        Schema::connection($this->connection)->create('user_settings', function (Blueprint $collection) {
            $collection->id();
            $collection->foreignIdFor(User::class)->index()->constrained()->cascadeOnDelete();
            $collection->document('metadata', function (Blueprint $collection) {
                $collection->timestamp('created_at')->useCurrent();
                $collection->string('created_by');
                $collection->timestamp('updated_at')->useCurrent();
                $collection->string('updated_by');
                $collection->timestamp('deleted_at')->nullable();
                $collection->string('deleted_by')->nullable();
            });
        });
    }
};