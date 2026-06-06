<?php

namespace App\Data\Location;

use InvalidArgumentException;

class District
{
    #region PROPERTIES
    private int $id;
    private string $name;
    private City $city;
    #endregion

    #region CONSTRUCT
    public function __construct(
        int $id,
        string $name,
        City $city
    ) {
        $this->setId($id);
        $this->setName($name);
        $this->setCity($city);
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

    public function getCity(): City
    {
        return $this->city;
    }
    #endregion

    #region SETTERS
    public function setId(int $value): void
    {
        if ($value <= 0) {
            throw new InvalidArgumentException('District ID must be a positive integer.');
        }
        $this->id = $value;
    }

    public function setName(string $value): void
    {
        if (empty(trim($value))) {
            throw new InvalidArgumentException('District name cannot be empty.');
        }
        $this->name = $value;
    }

    public function setCity(City $value): void
    {
        $this->city = $value;
    }
    #endregion

    #region UTILS
    public function toArray(): array
    {
        return [
            'id' => $this->getId(),
            'name' => $this->getName(),
            'city' => $this->getCity()->toArray(),
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
            City::fromArray($data['city'])
        );
    }
    #endregion
}