
<?php
// app/controllers/SignupController.php
// Alias for AuthController::register — signup.php delegates here

require_once __DIR__ . '/AuthController.php';

class SignupController extends AuthController {}
