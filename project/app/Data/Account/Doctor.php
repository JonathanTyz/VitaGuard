<?php

namespace App\Data\Account;

use App\Data\Location\Address;

use App\Data\Value\Account\Role;
use App\Data\Value\Account\Status;
use App\Data\Value\Account\Gender;
use App\Data\Medic\Specialty;

use Carbon\Carbon;
use InvalidArgumentException;

class Doctor extends User
{
    #region PROPERTIES
    private string $prefix_name;
    private string $first_name;
    private string $middle_name;
    private string $last_name;
    private string $suffix_name;
    private float $rating;
    private Gender $gender;
    private Carbon $date_of_birth;
    private Address $address;
    private array $specialties=[];
    #endregion

    #region CONSTRUCTOR
    public function __construct(
        string $username,
        string $email,
        string $phone_number,
        Status $status,
        string $prefix_name,
        string $first_name,
        string $middle_name,
        string $last_name,
        string $suffix_name,
        float $rating,
        Gender $gender,
        Carbon $date_of_birth,
        Address $address,
        array $specialties
    ) {
        parent::__construct($username, $email, $phone_number, Role::DOCTOR, $status);
        $this->setPrefixName($prefix_name);
        $this->setFirstName($first_name);
        $this->setMiddleName($middle_name);
        $this->setLastName($last_name);
        $this->setSuffixName($suffix_name);
        $this->setRating($rating);
        $this->setGender($gender);
        $this->setDateOfBirth($date_of_birth);
        $this->setAddress($address);
        $this->setSpecialties($specialties);
    }
    #endregion

    #region GETTERS
    public function getPrefixName(): string
    {
        return $this->prefix_name;
    }

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

    public function getSuffixName(): string
    {
        return $this->suffix_name;
    }

    public function getRating(): float
    {
        return $this->rating;
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

    /**
     * @return Specialty[]
     */
    public function getSpecialties(): array
    {
        return $this->specialties;
    }
    #endregion

    #region SETTERS
    public function setPrefixName(string $value): void
    {
        if (empty(trim($value))) {
            throw new InvalidArgumentException('Prefix name cannot be empty.');
        }
        if (mb_strlen($value) > config('data.max_name_length')) {
            throw new InvalidArgumentException('Prefix name cannot exceed ' . config('data.max_name_length') . ' characters.');
        }
        $this->prefix_name = $value;
    }

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

    public function setSuffixName(string $value): void
    {
        if (mb_strlen($value) > config('data.max_name_length')) {
            throw new InvalidArgumentException('Suffix name cannot exceed ' . config('data.max_name_length') . ' characters.');
        }
        $this->suffix_name = $value;
    }

    public function setRating(float $value): void
    {
        if ($value < 0.0) {
            throw new InvalidArgumentException('Rating cannot be negative.');
        }
        $this->rating = $value;
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

    public function setSpecialties(array $specialties)
    {
        foreach ($specialties as $specialty) {
            $this->addSpecialty($specialty);
        }
    }

    public function addSpecialty(Specialty $specialty)
    {
        $this->specialties[] = $specialty;
    }
    #endregion

    #region UTILITIES
    public function toArray(): array
    {
        return array_merge(parent::toArray(), [
            'prefix_name' => $this->getPrefixName(),
            'first_name' => $this->getFirstName(),
            'middle_name' => $this->getMiddleName(),
            'last_name' => $this->getLastName(),
            'suffix_name' => $this->getSuffixName(),
            'rating' => $this->getRating(),
            'gender' => $this->getGender()->value,
            'date_of_birth' => $this->getDateOfBirth()->toDateTimeString(),
            'address' => $this->getAddress()->toArray(),
            'specialties' => array_map(fn(Specialty $specialty) => $specialty->toArray(), $this->getSpecialties())
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
            $data['prefix_name'],
            $data['first_name'],
            $data['middle_name'],
            $data['last_name'],
            $data['suffix_name'],
            (float) $data['rating'],
            Gender::from($data['gender']),
            Carbon::parse($data['date_of_birth']),
            Address::fromArray($data['address']),
            $data['specialties']
        );
    }
    #endregion
}