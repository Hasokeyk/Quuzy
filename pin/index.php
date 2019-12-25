<?php 

    // You may need to amend this path to locate Composer's autoloader
    require('vendor/autoload.php'); 

    use seregazhuk\PinterestBot\Factories\PinterestBot;

    $bot = PinterestBot::create();

    // Login
    $bot->auth->login('quuzy@setiabudihitz.com', '48186hasokeyk');

    $bot->boards->create('test', 'Description');