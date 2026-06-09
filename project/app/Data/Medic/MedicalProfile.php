<?php

namespace App\Data\Medic;

use Carbon\Carbon;
use App\Data\Account\User;
use App\Data\Account\Member;
use App\Data\Value\Medic\AlcoholConsumption;
use App\Data\Value\Medic\BloodType;
use App\Data\Value\Medic\SmokingStatus;
use InvalidArgumentException;

class MedicalProfile
{
    #region PROPERTIES
    private int $id;
    private string $description;
    private BloodType $blood_type;
    private float $height;
    private float $weight;
    private SmokingStatus $smoking_status;
    private AlcoholConsumption $alcohol_consumption;
    private User $creator;
    private Member $patient;
    private Carbon $diagnosed_date;
    #endregion

    #region CONSTRUCTOR
    public function __construct(
        int $id,
        string $description,
        BloodType $blood_type,
        float $height,
        float $weight,
        SmokingStatus $smoking_status,
        AlcoholConsumption $alcohol_consumption,
        User $creator,
        Member $patient,
        Carbon $diagnosed_date
    ) {
        $this->setId($id);
        $this->setDescription($description);
        $this->setBloodType($blood_type);
        $this->setHeight($height);
        $this->setWeight($weight);
        $this->setSmokingStatus($smoking_status);
        $this->setAlcoholConsumption($alcohol_consumption);
        $this->setCreator($creator);
        $this->setPatient($patient);
        $this->setDiagnosedDate($diagnosed_date);
    }
    #endregion

    #region GETTERS
    public function getId(): int
    {
        return $this->id;
    }

    public function getDescription(): string
    {
        return $this->description;
    }

    public function getBloodType(): BloodType
    {
        return $this->blood_type;
    }

    public function getHeight(): float
    {
        return $this->height;
    }

    public function getWeight(): float
    {
        return $this->weight;
    }

    public function getSmokingStatus(): SmokingStatus
    {
        return $this->smoking_status;
    }

    public function getAlcoholConsumption(): AlcoholConsumption
    {
        return $this->alcohol_consumption;
    }

    public function getCreator(): User
    {
        return $this->creator;
    }

    public function getPatient(): Member
    {
        return $this->patient;
    }

    public function getDiagnosedDate(): Carbon
    {
        return $this->diagnosed_date;
    }
    #endregion

    #region SETTERS
    public function setId(int $value): void
    {
        if ($value <= 0) {
            throw new InvalidArgumentException('ID must be a positive integer.');
        }
        $this->id = $value;
    }

    public function setDescription(string $value): void
    {
        if (empty(trim($value))) {
            throw new InvalidArgumentException('Description cannot be empty.');
        }
        $this->description = $value;
    }

    public function setBloodType(BloodType $value): void
    {
        $this->blood_type = $value;
    }

    public function setHeight(float $value): void
    {
        if ($value <= 0) {
            throw new InvalidArgumentException('Height must be greater than zero.');
        }
        $this->height = $value;
    }

    public function setWeight(float $value): void
    {
        if ($value <= 0) {
            throw new InvalidArgumentException('Weight must be greater than zero.');
        }
        $this->weight = $value;
    }

    public function setSmokingStatus(SmokingStatus $value): void
    {
        $this->smoking_status = $value;
    }

    public function setAlcoholConsumption(AlcoholConsumption $value): void
    {
        $this->alcohol_consumption = $value;
    }

    public function setCreator(User $value): void
    {
        $this->creator = $value;
    }

    public function setPatient(Member $value): void
    {
        $this->patient = $value;
    }

    public function setDiagnosedDate(Carbon $value): void
    {
        $this->diagnosed_date = $value;
    }
    #endregion

    #region UTILITIES
    public function toArray(): array
    {
        return [
            'id'                 => $this->getId(),
            'description'        => $this->getDescription(),
            'blood_type'          => $this->getBloodType()->value,
            'height'             => $this->getHeight(),
            'weight'             => $this->getWeight(),
            'smoking_status'      => $this->getSmokingStatus()->value,
            'alcohol_consumption' => $this->getAlcoholConsumption()->value,
            'creator'            => $this->getCreator()->toArray(),
            'patient'            => $this->getPatient()->toArray(),
            'diagnosed_date'      => $this->getDiagnosedDate()->toDateTimeString(),
        ];
    }

    public static function fromArray(array $data): self
    {
        check_array_keys(
            array_keys(get_class_vars(self::class)),
            $data,
            class_basename(self::class)
        );

        return new self(
            (int) $data['id'],
            $data['description'],
            BloodType::from($data['blood_type']),
            (float) $data['height'],
            (float) $data['weight'],
            SmokingStatus::from($data['smoking_status']),
            AlcoholConsumption::from($data['alcohol_consumption']),
            User::fromArray($data['creator']), 
            Member::fromArray($data['patient']),
            Carbon::parse($data['diagnosed_date'])
        );
    }
    #endregion
}