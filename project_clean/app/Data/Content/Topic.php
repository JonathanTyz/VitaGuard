<?php

namespace App\Data\Content;

use InvalidArgumentException;

class Topic {
    #region PROPERTIES
    public int $id {
        get => $this->id;
        set (int $value) {
            if ($value <= 0) {
                throw new InvalidArgumentException('Topic ID must be a positive integer.');
            }
            $this->id = $value;
        }
    }

    public string $name {
        get => $this->name;
        set (string $value) {
            if (empty(trim($value))) {
                throw new InvalidArgumentException('Topic name cannot be empty.');
            }
            $this->name = $value;
        }
    }
    #endregion

    #region CONSTRUCT
    public function __construct(int $id = 0, string $name = '') {
        $this->id = $id;
        $this->name = $name;
    }
    #endregion

    #region UTILS
    public function toArray(): array {
        return [
            'id'   => $this->id,
            'name' => $this->name,
        ];
    }
    public static function fromArray(array $data): self {
        return new self(
            $data['id'] ?? 0,
            $data['name'] ?? ''
        );
    }
    #endregion
}