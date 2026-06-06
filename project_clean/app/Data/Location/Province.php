<?php

namespace App\Data\Location;

use InvalidArgumentException;

class Province
{
    #region PROPERTIES
    private int $id;
    private string $name;
    #endregion

    #region CONSTRUCT
    public function __construct(int $id, string $name)
    {
        $this->setId($id);
        $this->setName($name);
    }
    #endregion

    #region GETTER
    public function getId(): int
    {
        return $this->id;
    }

    public function getName(): string
    {
        return $this->name;
    }
    #endregion 
    #region SETTER
    public function setId(int $id): void
    {
        if ($id <= 0) {
            throw new InvalidArgumentException('Province ID must be a positive integer.');
        }
        $this->id = $id;
    }

    public function setName(string $value): void
    {
        $value = trim($value);
        $maxLength = config("data.max_location_name_length");
        if (empty($value)) {
            throw new InvalidArgumentException('Province name cannot be empty.');
        }
        if (mb_strlen($value) > $maxLength) {
            throw new InvalidArgumentException("Province name cannot exceed {$maxLength} characters.");
        }
        $this->name = $value;
    }
    #endregion

    #region UTILS
    public function toArray(): array
    {
        return [
            'id' => $this->getId(),
            'name' => $this->getName(),
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
            $data['name']
        );
    }
    #endregion
}