<?php

class PageController extends Controller
{
    public function home(): void
    {
        $upcoming = array_filter((new EventRepository())->all(), fn($e) => $e['date'] >= date('Y-m-d'));
        $this->render('home', ['events' => array_slice($upcoming, 0, 3)]);
    }

    public function events(): void
    {
        $this->render('events', ['events' => (new EventRepository())->all()]);
    }

    public function notFound(): void
    {
        $this->render('404', [], 404);
    }
}
