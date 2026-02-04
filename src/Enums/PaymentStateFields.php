<?php

namespace BornMT\ApcoPay\Enums;

enum PaymentStateFields: int
{
    case CANCELLED = 2;
    case SUCCESS = 3;
    case FAILED = 4;
}
