<?php

namespace App\Data\Location;

use InvalidArgumentException;

class Address
{
    #region PROPERTIES
    private string $detail;
    private District $district;
    #endregion

    #region CONSTRUCT
    public function __construct(string $detail, District $district)
    {
        // Route through setters to enforce validation logic upon instantiation
        $this->setDetail($detail);
        $this->setDistrict($district);
    }
    #endregion

    #region GETTERS
    public function getDetail(): string
    {
        return $this->detail;
    }

    public function getDistrict(): District
    {
        return $this->district;
    }
    #endregion

    #region SETTERS
    public function setDetail(string $value): void
    {
        if (empty(trim($value))) {
            throw new InvalidArgumentException('Address detail cannot be empty.');
        }
        $this->detail = $value;
    }

    public function setDistrict(District $value): void
    {
        $this->district = $value;
    }
    #endregion

    #region UTILS
    public function toArray(): array
    {
        return [
            'detail' => $this->getDetail(),
            'district' => $this->getDistrict()->toArray(),
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
            $data['detail'],
            District::fromArray($data['district'])
        );
    }
    #endregion
}