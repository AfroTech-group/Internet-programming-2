<?php
function load_dotenv($path)
{
    if (!file_exists($path)) {
        return [];
    }

    $lines = file($path, FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES);
    $data = [];
    foreach ($lines as $line) {
        $line = trim($line);
        if ($line === '' || $line[0] === '#') continue;
        if (strpos($line, '=') === false) continue;
        list($name, $value) = explode('=', $line, 2);
        $name = trim($name);
        $value = trim($value);

        if ((substr($value, 0, 1) === '"' && substr($value, -1) === '"') || (substr($value, 0, 1) === "'" && substr($value, -1) === "'")) {
            $value = substr($value, 1, -1);
        }
        $data[$name] = $value;
    }
    return $data;
}

// load .env from project root (same dir as this file)
$__APP_ENV = load_dotenv(__DIR__ . DIRECTORY_SEPARATOR . '.env');

function env($key, $default = null)
{
    global $__APP_ENV;
    return isset($__APP_ENV[$key]) ? $__APP_ENV[$key] : $default;
}
