<?php

declare(strict_types = 1);

namespace Prosperty\Core\Domain\Spy\Enums;

enum Permission: string
{
    case CREATE = 'spy:create';
    case RETRIEVE = 'spy:retrieve';
    case RETRIEVE_RANDOM = 'spy:retrieve-random-collection';
    case RETRIEVE_ALL = 'spy:retrieve-all';
    case FULL_WRITE_PERMISSION = 'spy:full-write-permission';
    case FULL_READ_PERMISSION = 'spy:full-read-permission';
    case FULL_PERMISSION = 'spy:full-permission';
}
