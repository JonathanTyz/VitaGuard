<?php

namespace App\Data\Value\Account;

use App\Data\Account\Member;
use App\Data\Account\Doctor;
use App\Data\Account\FacilityAdmin;
use App\Data\Account\Admin;
enum Role:string{
    case MEMBER = "member";
    case DOCTOR = "doctor";
    case FACILITY_ADMIN = "facility_admin";
    case ADMIN = "admin";

    public function getClass(): string {
        return match($this) {
            self::MEMBER => Member::class,
            self::DOCTOR => Doctor::class,
            self::FACILITY_ADMIN => FacilityAdmin::class,
            self::ADMIN => Admin::class
        };
    }
}