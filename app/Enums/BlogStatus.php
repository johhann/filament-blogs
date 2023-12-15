<?php

namespace App\Enums;

enum BlogStatus: string
{
    case SUBMITTED = 'Submitted';
    case PUBLISHED = 'Published';
    case REJECTED = 'Rejected';

    public function getDescription()
    {

    }
}
