<?php

require_once __DIR__ . '/vendor/autoload.php';

spl_autoload_register(function ($class) {
      $prefixes = [
            "Controllers\\" => __DIR__ ."/controllers/",
            "Models\\" => __DIR__ ."/models/",
            "Middleware\\" => __DIR__ ."/middleware/",
            "Classes\\" => __DIR__ ."/classes/",
            "Requests\\" => __DIR__ ."/requests/",
            "Responses\\" => __DIR__ ."/responses/",
            "Routes\\" => __DIR__ ."/routes/",
            "Views\\" => __DIR__ ."/views/"
        ];
    
        foreach ($prefixes as $prefix => $base_dir) {
            if (str_starts_with($class, $prefix)) {
                $relative_class = substr($class, strlen($prefix));
                $file = $base_dir . $relative_class . '.php';
    
                if (file_exists($file)) {
                    require $file;
                    return;
                }
            }
      }
});