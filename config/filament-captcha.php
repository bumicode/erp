<?php

// config for DominionSolutions/FilamentCaptcha
return [
    // The engine to use for captcha generation
    // Currently supported engines are: mews
    'engine' => env('CAPTCHA_ENGINE', 'mews'),
];
