<?php
namespace App\Enums;

enum RssFeedIntervalType: string {
    case MINUTES = 'minutes';
    case HOURS = 'hours';
    case DAYS = 'days';
}