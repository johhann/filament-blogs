<?php

namespace App\Enums;

enum BlogStatus: string
{
    case SUBMITTED = 'Submitted';
    case PUBLISHED = 'Published';
    case REJECTED = 'Rejected';

    public function getColor()
    {
        return match ($this) {
            self::SUBMITTED => 'primary',
            self::PUBLISHED => 'success',
            self::REJECTED => 'danger',
        };
    }
}
