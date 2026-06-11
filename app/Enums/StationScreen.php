<?php

namespace App\Enums;

enum StationScreen: string
{
    case LOCKED = 'locked';
    case WAITING = 'waiting';
    case ACTIVE = 'active';
    case WEIGHT_CHECK = 'weight-check';
    case WEIGHT_DEVIATION = 'weight-deviation';
    case PRINTING = 'printing';
    case PACKED = 'packed';
    case ERROR = 'error';
    case CANCEL_RETURN = 'cancel-return';
}