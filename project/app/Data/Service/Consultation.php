<?php

namespace App\Data\Service;

use Carbon\Carbon;
use InvalidArgumentException;

class Consultation
{
    #region FIELDS
    private int $id;
    private Carbon $start_time;
    private ?Carbon $end_time;
    private string $notes;
    private ?Carbon $paid_at;
    #endregion

    #region CONSTRUCTOR
    public function __construct(
        int $id,
        Carbon $start_time,
        string $notes,
        ?Carbon $end_time = null,
        ?Carbon $paid_at = null
    ) {
        $this->setId($id);
        $this->setStartTime($start_time);
        $this->setNotes($notes);
        $this->setEndTime($end_time);
        $this->setPaidAt($paid_at);
    }
    #endregion

    #region GETTERS
    public function getId(): int
    {
        return $this->id;
    }

    public function getStartTime(): Carbon
    {
        return $this->start_time;
    }

    public function getEndTime(): ?Carbon
    {
        return $this->end_time;
    }

    public function getNotes(): string
    {
        return $this->notes;
    }

    public function getPaidAt(): ?Carbon
    {
        return $this->paid_at;
    }

    public function isClosed(): bool
    {
        if ($this->end_time === null) {
            return false;
        } else {
            return true;
        }
    }
    #endregion

    #region SETTERS
    public function setId(int $value): void
    {
        $this->id = $value;
    }

    public function setStartTime(Carbon $value): void
    {
        $this->start_time = $value;
    }

    public function setEndTime(?Carbon $value): void
    {
        if ($value !== null && $value <= $this->start_time) {
            throw new InvalidArgumentException("End time must be after start time.");
        }
        $this->end_time = $value;
    }

    public function setNotes(string $value): void
    {
        $this->notes = $value;
    }

    public function setPaidAt(?Carbon $value): void
    {
        $this->paid_at = $value;
    }
    #endregion

    #region UTILS
    public function toArray(): array
    {
        return [
            'id' => $this->getId(),
            'start_time' => $this->getStartTime()->toTimeString(),
            'end_time' => $this->getEndTime()?->toTimeString(),
            'notes' => $this->getNotes(),
            'paid_at' => $this->getPaidAt()?->toIso8601String(),
        ];
    }

    public static function fromArray(array $data): self
    {
        $expectedKeys = ['id', 'start_time', 'end_time', 'notes', 'paid_at'];

        check_array_keys(
            $expectedKeys,
            $data,
            class_basename(self::class)
        );

        return new self(
            (int) $data['id'],
            Carbon::parse($data['start_time']),
            (string) $data['notes'],
            !empty($data['end_time']) ? Carbon::parse($data['end_time']) : null,
            !empty($data['paid_at']) ? Carbon::parse($data['paid_at']) : null
        );
    }
    #endregion
}