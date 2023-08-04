<?php

namespace App\Enums;

enum TicketStatus: string
{
    case OPEN = 'open';
    case RESOLVED = 'Resolved';
    case REJECTED = 'Rejected';

}
