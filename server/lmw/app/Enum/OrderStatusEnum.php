<?php

namespace App\Enum;

enum OrderStatusEnum:string
{
    case INITIATED = 'Initiated';
    case VISITOR = 'Assigned';
    case DELIVERED = 'Delivered';
    case CANCELLED = 'Cancelled';
}
