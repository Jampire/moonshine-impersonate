<?php

declare(strict_types=1);

namespace Jampire\MoonshineImpersonate\Tests\Stubs\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\MorphTo;

class MoonshineChangeLog extends Model
{
    protected $table = 'moonshine_change_logs';

    protected $fillable = [
        'moonshine_user_id',
        'changelogable_id',
        'changelogable_type',
        'states_before',
        'states_after',
    ];

    protected $casts = [
        'states_before' => 'array',
        'states_after' => 'array',
    ];

    public function changelogable(): MorphTo
    {
        return $this->morphTo();
    }
}
