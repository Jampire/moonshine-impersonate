<?php

declare(strict_types=1);

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateMoonShineChangeLogsTable extends Migration
{
    public function up(): void
    {
        Schema::create('moonshine_change_logs', function (Blueprint $table): void {
            $table->id();
            $table->foreignId('moonshine_user_id');
            $table->morphs('changelogable');
            $table->longText('states_before');
            $table->longText('states_after');
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('moonshine_change_logs');
    }
};
