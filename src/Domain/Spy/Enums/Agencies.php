<?php

declare(strict_types = 1);

namespace Prosperty\Core\Domain\Spy\Enums;

enum Agencies: string
{
    case AGENCY_FBI = 'FBI';
    case AGENCY_CIA = 'CIA';
    case AGENCY_NSA = 'NSA';
    case AGENCY_DIA = 'DIA';
    case AGENCY_NRO = 'NRO';
    case AGENCY_NGA = 'NGA';
    case AGENCY_NCIJTF = 'NCIJTF';
    case AGENCY_NCTC = 'NCTC';
    case AGENCY_TFI = 'TFI';
    case AGENCY_IARPA = 'IARPA';
    case AGENCY_ONI = 'ONI';
    case AGENCY_AFISRA = 'AFISRA';
}
