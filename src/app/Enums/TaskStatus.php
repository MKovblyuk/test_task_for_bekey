<?php

namespace App\Enums;

use App\Traits\InteractingWithEnums;

enum TaskStatus : string
{
    use InteractingWithEnums;

    case Completed = 'Completed';
    case Uncompleted = 'Uncompleted';
}