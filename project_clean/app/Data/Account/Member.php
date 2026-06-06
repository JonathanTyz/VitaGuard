<?php

namespace App\Data\Account;

use App\Data\Location\Address;

use App\Data\Value\Account\Role;
use App\Data\Value\Account\Status;
use App\Data\Value\Account\Gender;

use Carbon\Carbon;
use InvalidArgumentException;

class Member extends User
{
    #region PROPERTIES
    public string $firstName {
        get => $this->firstName;
        set(string $value) {
            if (empty(trim($value))) {
                throw new InvalidArgumentException('First name cannot be empty.');
            }
            $this->firstName = $value;
        }
    }

    public string $middleName {
        get => $this->middleName;
        set(string $value) => $this->middleName = trim($value);
    }

    public string $lastName {
        get => $this->lastName;
        set(string $value) {
            if (empty(trim($value))) {
                throw new InvalidArgumentException('Last name cannot be empty.');
            }
            $this->lastName = $value;
        }
    }

    public Gender $gender {
        get => $this->gender;
        set(Gender $value) => $this->gender = $value;
    }

    public Carbon $dateOfBirth {
        get => $this->dateOfBirth;
        set(Carbon $value) => $this->dateOfBirth = $value;
    }

    public Address $address {
        get => $this->address;
        set(Address $value) => $this->address = $value;
    }
    #endregion

    #region CONSTRUCTOR
    public function __construct(
        string $username = '',
        string $email = '',
        string $phoneNumber = '',
        Status $status = Status::ACTIVE,
        string $firstName = '',
        string $middleName = '',
        string $lastName = '',
        Gender $gender = Gender::MALE,
        ?Carbon $dateOfBirth = null,
        ?Address $address = null
    ) {
        parent::__construct($username, $email, $phoneNumber, Role::MEMBER, $status);

        $this->firstName = $firstName;
        $this->middleName = $middleName;
        $this->lastName = $lastName;
        $this->gender = $gender;
        $this->dateOfBirth = $dateOfBirth ?? Carbon::now();
        $this->address = $address ?? new Address();
    }
    #endregion

    #region UTILITIES
    public function toArray(): array
    {
        return array_merge(parent::toArray(), [
            'firstName' => $this->firstName,
            'middleName' => $this->middleName,
            'lastName' => $this->lastName,
            'gender' => $this->gender->value,
            'dateOfBirth' => $this->dateOfBirth->toDateTimeString(),
            'address' => $this->address->toArray(),
        ]);
    }

    public static function fromArray(array $data): static 
    {
        $userInstance = parent::fromArray($data);

        return new self(
            $userInstance->username,
            $userInstance->email,
            $userInstance->phoneNumber,
            $userInstance->status,
            $data['firstName'] ?? '',
            $data['middleName'] ?? '',
            $data['lastName'] ?? '',
            isset($data['gender']) ? Gender::from($data['gender']) : Gender::MALE,
            isset($data['dateOfBirth']) ? Carbon::parse($data['dateOfBirth']) : null,
            isset($data['address']) && is_array($data['address']) ? Address::fromArray($data['address']) : null
        );
    }
    #endregion
}