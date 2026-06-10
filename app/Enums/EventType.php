<?php

namespace App\Enums;

enum EventType: string
{
    case USER_LOGIN = 'user_login';
    case RFID_SCAN = 'rfid_scan';
    case PICK_STARTED = 'pick_started';
    case PICK_COMPLETED = 'pick_completed';
    case WEIGHT_CHECK_PASSED = 'weight_check_passed';
    case WEIGHT_CHECK_FAILED = 'weight_check_failed';
    case LABEL_PRINTED = 'label_printed';

}