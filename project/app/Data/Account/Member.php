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
    private string $first_name;
    private string $middle_name;
    private string $last_name;
    private Gender $gender;
    private Carbon $date_of_birth;
    private Address $address;
    #endregion

    #region CONSTRUCTOR
    public function __construct(
        string $username,
        string $email,
        string $phone_number,
        Status $status,
        string $first_name,
        string $middle_name,
        string $last_name,
        Gender $gender,
        Carbon $date_of_birth,
        Address $address
    ) {
        parent::__construct($username, $email, $phone_number, Role::MEMBER, $status);
        $this->setFirstName($first_name);
        $this->setMiddleName($middle_name);
        $this->setLastName($last_name);
        $this->setGender($gender);
        $this->setDateOfBirth($date_of_birth);
        $this->setAddress($address);
    }
    #endregion

    #region GETTERS
    public function getFirstName(): string
    {
        return $this->first_name;
    }

    public function getMiddleName(): string
    {
        return $this->middle_name;
    }

    public function getLastName(): string
    {
        return $this->last_name;
    }

    public function getGender(): Gender
    {
        return $this->gender;
    }

    public function getDateOfBirth(): Carbon
    {
        return $this->date_of_birth;
    }

    public function getAddress(): Address
    {
        return $this->address;
    }
    #endregion

    #region SETTERS
    public function setFirstName(string $value): void
    {
        if (empty(trim($value))) {
            throw new InvalidArgumentException('First name cannot be empty.');
        }
        if (mb_strlen($value) > config('data.max_name_length')) {
            throw new InvalidArgumentException('First name cannot exceed ' . config('data.max_name_length') . ' characters.');
        }
        $this->first_name = $value;
    }

    public function setMiddleName(string $value): void
    {
        if (mb_strlen($value) > config('data.max_name_length')) {
            throw new InvalidArgumentException('Middle name cannot exceed ' . config('data.max_name_length') . ' characters.');
        }
        $this->middle_name = $value;
    }

    public function setLastName(string $value): void
    {
        if (empty(trim($value))) {
            throw new InvalidArgumentException('Last name cannot be empty.');
        }
        if (mb_strlen($value) > config('data.max_name_length')) {
            throw new InvalidArgumentException('Last name cannot exceed ' . config('data.max_name_length') . ' characters.');
        }
        $this->last_name = $value;
    }

    public function setGender(Gender $value): void
    {
        $this->gender = $value;
    }

    public function setDateOfBirth(Carbon $value): void
    {
        $this->date_of_birth = $value;
    }

    public function setAddress(Address $value): void
    {
        $this->address = $value;
    }
    #endregion

    #region UTILITIES
    public function toArray(): array
    {
        return array_merge(parent::toArray(), [
            'first_name' => $this->getFirstName(),
            'middle_name' => $this->getMiddleName(),
            'last_name' => $this->getLastName(),
            'gender' => $this->getGender()->value,
            'date_of_birth' => $this->getDateOfBirth()->toDateTimeString(),
            'address' => $this->getAddress()->toArray(),
        ]);
    }

    public static function fromArray(array $data): self
    {
        check_array_keys(
            array_keys(get_class_vars(self::class)),
            $data,
            class_basename(self::class)
        );

        return new self(
            $data['username'],
            $data['email'],
            $data['phone_number'],
            Status::from($data['status']),
            $data['first_name'],
            $data['middle_name'],
            $data['last_name'],
            Gender::from($data['gender']),
            Carbon::parse($data['date_of_birth']),
            Address::fromArray($data['address'])
        );
    }
    #endregion
}