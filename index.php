<?php

Kirby::plugin('salinapl/lst-calendar',
    [
        'areas' => [
            'lst-calendar' => function($kirby) {
                return [
                    // Panel Config
                    'label' => 'LST Calendar',
                    'icon' => 'calendar',
                    'menu' => true,
                    'link' => 'lst-calendar',

                    // Views
                    'views' => [
                        require __DIR__ . '/views/lst-calendar.php'
                    ]
                ];
            }
            
        ]
    ]
);