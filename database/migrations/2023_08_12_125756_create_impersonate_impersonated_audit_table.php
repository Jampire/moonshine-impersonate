<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Jampire\MoonshineImpersonate\Support\Settings;
use MoonShine\Models\MoonshineUser;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('impersonate_impersonated_audit', function (Blueprint $table): void {
            $table->id();
            $table->foreignIdFor(MoonshineUser::class)
                ->nullable()
                ->constrained()
                ->cascadeOnUpdate()
                ->nullOnDelete();
            $table->foreignIdFor(Settings::userClass())
                ->constrained()
                ->cascadeOnUpdate()
                ->cascadeOnDelete();
            $table->bigInteger('counter')->unsigned()->default(1);
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('impersonate_impersonated_audit');
    }
};
