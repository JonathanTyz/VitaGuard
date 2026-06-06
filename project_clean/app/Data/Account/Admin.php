<?php

namespace App\Data\Account;

use App\Data\Value\Account\Role;
use App\Data\Value\Account\Status;

class Admin extends User
{

    #region CONSTRUCTOR
    public function __construct(
        string $username = '',
        string $email = '',
        string $phoneNumber = '',
        Status $status = Status::ACTIVE
    ) {
        parent::__construct($username, $email, $phoneNumber, Role::ADMIN, $status);
    }
    #endregion

    #region UTILITIES
    public function toArray(): array
    {
        return parent::toArray();
    }

    public static function fromArray(array $data): static
    {
        $userInstance = parent::fromArray($data);
        return new self(
            $userInstance->username,
            $userInstance->email,
            $userInstance->phoneNumber,
            $userInstance->status
        );
    }
    #endregion
}