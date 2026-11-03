<?php

class ReviewRepository
{
    public function create(int $requestId, string $text, int $rating): void
    {
        $st = Database::get()->prepare('INSERT INTO reviews (request_id, text, rating) VALUES (?, ?, ?)');
        $st->execute([$requestId, $text, $rating]);
    }
}
