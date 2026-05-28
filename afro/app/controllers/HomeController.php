<?php
// app/controllers/HomeController.php

require_once __DIR__ . '/../core/Auth.php';
require_once __DIR__ . '/../models/Event.php';

class HomeController
{
    public function index(): void
    {
        $eventModel    = new Event();
        $featuredEvents = $eventModel->getAll(['limit' => 3]);
        include __DIR__ . '/../views/home/index.php';
    }
}
