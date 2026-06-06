<?php

namespace App\Data\Value\Account;

enum Status:string{
    case ACTIVE = "active";
    case SUSPENDED = "suspended";
}