<?php
// app/controllers/ContactController.php

require_once __DIR__ . '/../core/Auth.php';

class ContactController
{
    public function index(): void
    {
        include __DIR__ . '/../views/contact/index.php';
    }
}
