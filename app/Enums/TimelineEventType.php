<?php

namespace App\Enums;

enum TimelineEventType: string
{
    case Note = 'note';
    case StatusChange = 'status_change';
    case PriorityChange = 'priority_change';
    case Assigned = 'assigned';
    case Unassigned = 'unassigned';
}
