<?php

Kirby::plugin('salinapl/lst-calendar',
    [
        'collections' => [
            'slides' => function($site) {
                // Replace slideshows with the page where galleries are located
                if ($targetPage = $site->find('slideshows')) {
                    return $targetPage->slideGalleries()->toPages()->images();
                }

                // Return an empty files collection is page doesn't exist
                return new Kirby\Cms\Files();
            },
            'events' => function($site) {
                // Replace slideshows with the page where slideshows are located
                if ($targetPage = $site->find('slideshows')) {
                    return $targetPage->slideshows()->children()->listed()->events()->toStructure();
                }

                // Return an empty files collection is page doesn't exist
                return new Kirby\Cms\Files();
            }
        ]
    ]
);