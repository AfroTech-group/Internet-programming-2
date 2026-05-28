<?php
// app/controllers/FeaturesController.php

require_once __DIR__ . '/../core/Auth.php';

class FeaturesController
{
    public function index(): void
    {
        include __DIR__ . '/../views/features/index.php';
    }
}
