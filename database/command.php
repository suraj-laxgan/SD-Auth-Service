<?php

// 1. Controller : php artisan make:controller AuthController


// Job : php artisan make:job UserRegisterJob
// Event : php artisan make:event UserRegisterEvent
// Listner : php artisan make:listener UserRegisterListener --event=UserRegisterEvent


// Docker extension run in CMD : docker exec -it auth_worker
// Use Predis : composer require predis/predis
// run worker :  php artisan queue:work --queue=emails
// config : php artisan config:clear
// cache :php artisan cache:clear