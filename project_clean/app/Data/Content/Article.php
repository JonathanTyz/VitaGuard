<?php

namespace App\Data\Content;

use App\Data\Account\User;
use App\Data\Content\Topic;
use Carbon\Carbon;
use InvalidArgumentException;

class Article
{
    #region PROPERTIES
    public User $creator {
        get => $this->creator;
        set(User $value) {
            $this->creator = $value;
        }
    }

    public Topic $topic {
        get => $this->topic;
        set(Topic $value) {
            $this->topic = $value;
        }
    }

    public string $content {
        get => $this->content;
        set(string $value) {
            if (empty(trim($value))) {
                throw new InvalidArgumentException('Article content cannot be empty.');
            }
            $this->content = $value;
        }
    }

    public Carbon $created_at {
        get => $this->created_at;
        set(Carbon $value) => $this->created_at = $value;
    }

    public Carbon $updated_at {
        get => $this->updated_at;
        set(Carbon $value) => $this->updated_at = $value;
    }
    #endregion

    #region CONSTRUCTOR
    public function __construct(
        User $creator,
        Topic $topic,
        string $content = '',
        ?Carbon $created_at = null,
        ?Carbon $updated_at = null
    ) {
        $this->creator = $creator;
        $this->topic = $topic;
        $this->content = $content;
        $this->created_at = $created_at ?? Carbon::now();
        $this->updated_at = $updated_at ?? Carbon::now();
    }
    #endregion

    #region UTILITIES
    public function toArray(): array
    {
        return [
            'creator'    => $this->creator->toArray(), 
            'topic'      => $this->topic->toArray(),
            'content'    => $this->content,
            'created_at' => $this->created_at->toDateTimeString(),
            'updated_at' => $this->updated_at->toDateTimeString(),
        ];
    }

    public static function fromArray(array $data): self
    {
        return new self(
            isset($data['creator']) && is_array($data['creator']) 
                ? User::fromArray($data['creator']) 
                : null,
                
            isset($data['topic']) && is_array($data['topic']) 
                ? Topic::fromArray($data['topic']) 
                : null,
                
            $data['content'] ?? '',
            isset($data['created_at']) ? Carbon::parse($data['created_at']) : null,
            isset($data['updated_at']) ? Carbon::parse($data['updated_at']) : null
        );
    }
    #endregion
}