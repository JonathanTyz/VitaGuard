<?php

namespace App\Data\Service;

use Carbon\Carbon;
use App\Data\Value\Schedule\DayOfWeek;

class DoctorSchedule extends DailySchedule
{
    #region FIELDS
    private Facility $facility;
    private string $notes;
    private ?int $slot_duration_minutes;
    private ?int $max_patients;
    private ?float $consultation_fee;
    #endregion 

    #region CONSTRUCTOR
    public function __construct(
        int $id,
        DayOfWeek $day,
        Carbon $open,
        Carbon $close,
        Facility $facility,
        string $notes,
        ?int $slot_duration_minutes = null,
        ?int $max_patients = null,
        ?float $consultation_fee = null,
        ?Carbon $break_start_time = null,
        ?Carbon $break_end_time = null
    ) {
        parent::__construct($id, $day, $open, $close, $break_start_time, $break_end_time);
        
        $this->setNotes($notes);
        $this->setFacility($facility);
        $this->setSlotDurationMinutes($slot_duration_minutes);
        $this->setMaxPatients($max_patients);
        $this->setConsultationFee($consultation_fee);
    }
    #endregion

    #region GETTERS
    public function getNotes(): string
    {
        return $this->notes;
    }

    public function getFacility(): Facility
    {
        return $this->facility;
    }

    public function getslotDurationMinutes(): ?int
    {
        return $this->slot_duration_minutes;
    }

    public function getMaxPatients(): ?int
    {
        return $this->max_patients;
    }

    public function getConsultationFee(): ?float
    {
        return $this->consultation_fee;
    }
    #endregion

    #region SETTERS
    public function setNotes(string $value): void
    {
        $this->notes = $value;
    }

    public function setFacility(Facility $value): void
    {
        $this->facility = $value;
    }

    public function setSlotDurationMinutes(?int $value): void
    {
        $this->slot_duration_minutes = $value;
    }

    public function setMaxPatients(?int $value): void
    {
        $this->max_patients = $value;
    }

    public function setConsultationFee(?float $value): void
    {
        $this->consultation_fee = $value;
    }
    #endregion

    #region UTILS
    public function toArray(): array
    {
        return array_merge(parent::toArray(), [
            'facility'         => $this->getFacility()->toArray(),
            'notes'            => $this->getNotes(),
            'slot_duration_minutes'         => $this->getslotDurationMinutes(),
            'max_patients'     => $this->getMaxPatients(),
            'consultation_fee' => $this->getConsultationFee(),
        ]);
    }

    public static function fromArray(array $data): self
    {
        $expectedKeys = [
            'id', 
            'day', 
            'open_time', 
            'close_time', 
            'break_start', 
            'break_end',
            'facility',
            'notes',
            'slot_duration_minutes',
            'max_patients',
            'consultation_fee'
        ];

        check_array_keys($expectedKeys, $data, class_basename(self::class));

        return new self(
            (int) $data['id'],
            DayOfWeek::from($data['day']),
            Carbon::parse($data['open_time']),
            Carbon::parse($data['close_time']),
            Facility::fromArray($data['facility']),
            (string) $data['notes'],
            isset($data['slot_duration_minutes']) ? (int) $data['slot_duration_minutes'] : null,
            isset($data['max_patients']) ? (int) $data['max_patients'] : null,
            isset($data['consultation_fee']) ? (float) $data['consultation_fee'] : null,
            !empty($data['break_start']) ? Carbon::parse($data['break_start']) : null,
            !empty($data['break_end']) ? Carbon::parse($data['break_end']) : null,
        );
    }
    #endregion
}