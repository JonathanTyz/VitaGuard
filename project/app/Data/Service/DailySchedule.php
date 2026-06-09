<?php

namespace App\Data\Service;

use Carbon\Carbon;
use App\Data\Value\Schedule\DayOfWeek;
use InvalidArgumentException;

abstract class DailySchedule
{
    #region FIELDS
    private int $id;
    private DayOfWeek $day;
    private Carbon $open;
    private Carbon $close;
    private ?Carbon $break_start_time;
    private ?Carbon $break_end_time;
    #endregion

    #region CONSTRUCTOR
    public function __construct(
        int $id,
        DayOfWeek $day,
        Carbon $open,
        Carbon $close,
        ?Carbon $break_start_time = null,
        ?Carbon $break_end_time = null
    ) {
        $this->setId($id);
        $this->setDay($day);
        $this->setOpen($open);
        $this->setClose($close);
        $this->setBreakStart($break_start_time);
        $this->setBreakEnd($break_end_time);
    }
    #endregion

    #region GETTERS
    public function getId(): int
    {
        return $this->id;
    }

    public function getDay(): DayOfWeek
    {
        return $this->day;
    }

    public function getOpen(): Carbon
    {
        return $this->open;
    }

    public function getClose(): Carbon
    {
        return $this->close;
    }

    public function getBreakStart(): ?Carbon
    {
        return $this->break_start_time;
    }

    public function getBreakEnd(): ?Carbon
    {
        return $this->break_end_time;
    }
    #endregion

    #region SETTERS
    public function setId(int $value): void
    {
        $this->id = $value;
    }

    public function setDay(DayOfWeek $value): void
    {
        $this->day = $value;
    }

    public function setOpen(Carbon $value): void
    {
        $this->open = $value;
    }

    public function setClose(Carbon $value): void
    {
        if ($value <= $this->open) {
            throw new InvalidArgumentException("Close time must be after open time.");
        }
        $this->close = $value;
    }

    public function setBreakStart(?Carbon $value): void
    {
        if ($value !== null && $value < $this->open) {
            throw new InvalidArgumentException("Break cannot start before opening time.");
        }
        $this->break_start_time = $value;
    }

    public function setBreakEnd(?Carbon $value): void
    {
        if ($value !== null && $this->break_start_time !== null) {
            if ($value <= $this->break_start_time) {
                throw new InvalidArgumentException("Break end time must be after break start time.");
            }
        }
        if ($value !== null && $value > $this->close) {
            throw new InvalidArgumentException("Break cannot end after closing time.");
        }
        $this->break_end_time = $value;
    }
    #endregion

    #region UTILITIES
    public function toArray(): array
    {
        return [
            'id'          => $this->getId(),
            'day'         => $this->getDay()->value,
            'open_time'   => $this->getOpen()->toTimeString(),
            'close_time'  => $this->getClose()->toTimeString(),
            'break_start_time' => $this->getBreakStart()?->toTimeString(),
            'break_end_time'   => $this->getBreakEnd()?->toTimeString(),
        ];
    }
    #endregion
}