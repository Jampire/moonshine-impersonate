<?php

declare(strict_types=1);

namespace Jampire\MoonshineImpersonate\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Jampire\MoonshineImpersonate\Support\Settings;
use MoonShine\Models\MoonshineUser;

/**
 * Class ImpersonatedAudit
 *
 * @author Dzianis Kotau <me@dzianiskotau.com>
 */
class ImpersonatedAudit extends Model
{
    protected $table = 'impersonate_impersonated_audit';

    protected $fillable = [
        'moonshine_user_id',
        'user_id',
        'counter',
    ];

    public function moonshineUser(): BelongsTo
    {
        return $this->belongsTo(MoonshineUser::class);
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(Settings::userClass());
    }

    public function count(): void
    {
        $this->increment('counter');
    }
}
