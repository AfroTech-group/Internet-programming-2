<?php
// app/controllers/SupportController.php

require_once __DIR__ . '/../core/Auth.php';

class SupportController
{
    public function index(): void
    {
        include __DIR__ . '/../views/support/index.php';
    }
}
