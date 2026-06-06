<?php

namespace App\Data\Location;

use InvalidArgumentException;

class City
{
    #region PROPERTIES
    private int $id;
    private string $name;
    private Province $province;
    #endregion

    #region CONSTRUCT
    public function __construct(
        int $id,
        string $name,
        Province $province
    ) {
        $this->setId($id);
        $this->setName($name);
        $this->setProvince($province);
    }
    #endregion

    #region GETTERS
    public function getId(): int
    {
        return $this->id;
    }

    public function getName(): string
    {
        return $this->name;
    }

    public function getProvince(): Province
    {
        return $this->province;
    }
    #endregion

    #region SETTERS
    public function setId(int $value): void
    {
        if ($value <= 0) {
            throw new InvalidArgumentException('City ID must be a positive integer.');
        }
        $this->id = $value;
    }

    public function setName(string $value): void
    {
        if (empty(trim($value))) {
            throw new InvalidArgumentException('City name cannot be empty.');
        }
        $this->name = $value;
    }

    public function setProvince(Province $value): void
    {
        if ($value == null) {
            throw new InvalidArgumentException('City Province cannot be null.');
        }
        $this->province = $value;
    }
    #endregion

    #region UTILS
    public function toArray(): array
    {
        return [
            'id' => $this->getId(),
            'name' => $this->getName(),
            'province' => $this->getProvince()->toArray(),
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
            $data['id'],
            $data['name'],
            Province::fromArray($data['province'])
        );
    }
    #endregion
}