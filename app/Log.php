<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Log extends Model
{
    public function reference()
    {
        return $this->morphTo()->withTrashed();
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function getBody(): string
    {
        return $this->body;
    }

    public function setBody(string $value): self
    {
        $this->body = $value;

        return $this;
    }

    public function getId(): int
    {
        return $this->id;
    }

    public function getUserId(): int
    {
        return $this->user_id;
    }

    public function setUserId(int $value): self
    {
        $this->user_id = $value;

        return $this;
    }

    public function getReferenceId(): int
    {
        return $this->reference_id;
    }

    public function setReferenceId(int $value): self
    {
        $this->reference_id = $value;

        return $this;
    }

    public function getReferenceType(): string
    {
        return $this->reference_type;
    }

    public function setReferenceType(string $value): self
    {
        $this->reference_type = $value;

        return $this;
    }
}
