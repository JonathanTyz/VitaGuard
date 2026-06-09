<?php

namespace App\Data\Medic;

use Carbon\Carbon;
use App\Data\Account\User;
use App\Data\Account\Member;
use InvalidArgumentException;

class MedicalHistory
{
    #region PROPERTIES
    private int $id;
    private string $description;
    private User $creator;
    private Member $patient;
    private Carbon $diagnosed_date;
    #endregion

    #region CONSTRUCTOR
    public function __construct(
        int $id,
        string $description,
        User $creator,
        Member $patient,
        Carbon $diagnosed_date
    ) {
        $this->setId($id);
        $this->setDescription($description);
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
            'id'            => $this->getId(),
            'description'   => $this->getDescription(),
            'creator'       => $this->getCreator()->toArray(),
            'patient'       => $this->getPatient()->toArray(),
            'diagnosed_date' => $this->getDiagnosedDate()->toDateTimeString(),
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
            User::fromArray($data['creator']), 
            Member::fromArray($data['patient']),
            Carbon::parse($data['diagnosed_date'])
        );
    }
    #endregion
}