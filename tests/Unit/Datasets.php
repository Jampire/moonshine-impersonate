<?php

declare(strict_types=1);

use MoonShine\Support\Enums\ToastType;

dataset('toast-set', [
    'success' => ToastType::SUCCESS,
    'error' => ToastType::ERROR,
    'info' => ToastType::INFO,
]);
