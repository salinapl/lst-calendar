<?php

Kirby::plugin('salinapl/lst-calendar',
    [
        'collections' => [
            'slides' => function($site) {
                // Initialize empty files container
                $allSlides = new Kirby\Cms\Files();
                // Replace slideshows with the page where galleries are located
                if ($targetPage = $site->find('slideshows')) {
                    foreach ($targetPage->slideGalleries()->toPages()->images() as $image) {
                        $allSlides->add($image);
                    }
                }

                // Return an empty files collection is page doesn't exist
                return $allSlides;
            },
            'events' => function($site) {
                // Initialize empty structure container
                $allEvents = new Kirby\Cms\Structure();
                if ($targetPage = $site->find('slideshows')) {      // Replace slideshows with the page where slideshows are located
                    $childPages = $targetPage->children()->listed();
                    foreach ($childPages as $child) {
                        $events = $child->events()->toStructure();
                        foreach ($events as $event) {
                            // Add each event to the temporary structure container
                            $allEvents->add($event);
                        }
                    }
                }

                // Return all events or empty if there are none
                return $allEvents;
            }
        ]
    ]
);