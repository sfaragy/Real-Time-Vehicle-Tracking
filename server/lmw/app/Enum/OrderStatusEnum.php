<?php

namespace App\Enum;

enum OrderStatusEnum:string
{
    case INITIATED = 'Initiated';
    case ASSIGNED = 'Assigned';
    case DELIVERED = 'Delivered';
    case CANCELLED = 'Cancelled';
}
