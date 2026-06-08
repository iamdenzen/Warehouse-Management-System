<?php

namespace App\Enums;
enum DeliveryNoteStatus: string
{
    case IN_PROGRESS = 'in_progress';
    case WEIGHED = 'weighed';
    case LABELED = 'labeled';
    case PRINTED = 'printed';
    case INVOICED = 'invoiced';
    case BLOCKED = 'blocked';
    case CANCELLED = 'cancelled';
}