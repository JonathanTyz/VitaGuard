<?php

namespace App\Data\Content;

use App\Data\Account\User;
use App\Data\Content\Topic;
use Carbon\Carbon;
use InvalidArgumentException;

class Article
{
    #region PROPERTIES
    private User $creator;
    private Topic $topic;
    private string $content;
    private Carbon $created_at;
    private Carbon $updated_at;
    #endregion

    #region CONSTRUCTOR
    public function __construct(
        User $creator,
        Topic $topic,
        string $content,
        ?Carbon $created_at = null,
        ?Carbon $updated_at = null
    ) {
        $this->setCreator($creator);
        $this->setTopic($topic);
        $this->setContent($content);
        $this->setCreatedAt($created_at ?? Carbon::now());
        $this->setUpdatedAt($updated_at ?? Carbon::now());
    }
    #endregion

    #region GETTERS
    public function getCreator(): User
    {
        return $this->creator;
    }

    public function getTopic(): Topic
    {
        return $this->topic;
    }

    public function getContent(): string
    {
        return $this->content;
    }

    public function getCreatedAt(): Carbon
    {
        return $this->created_at;
    }

    public function getUpdatedAt(): Carbon
    {
        return $this->updated_at;
    }
    #endregion

    #region SETTERS
    public function setCreator(User $creator): void
    {
        $this->creator = $creator;
    }

    public function setTopic(Topic $topic): void
    {
        $this->topic = $topic;
    }

    public function setContent(string $content): void
    {
        if (empty(trim($content))) {
            throw new InvalidArgumentException('Article content cannot be empty.');
        }
        $this->content = $content;
    }

    public function setCreatedAt(Carbon $created_at): void
    {
        $this->created_at = $created_at;
    }

    public function setUpdatedAt(Carbon $updated_at): void
    {
        $this->updated_at = $updated_at;
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
        check_array_keys(
            array_keys(get_class_vars(self::class)),
            $data,
            class_basename(self::class)
        );

        return new self(
            User::fromArray($data['creator']), 
            Topic::fromArray($data['topic']),
            $data['content'] ?? '',
            Carbon::parse($data['created_at']),
            Carbon::parse($data['updated_at'])
        );
    }
    #endregion
}