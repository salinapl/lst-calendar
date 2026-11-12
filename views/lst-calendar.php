<?php

return [
    // the Panel patterns must not start with 'panel/',
    // the `panel` slug is automatically prepended.
    'pattern' => 'lst-calendar',

    // Action executes when the view is called
    'action'  => function () {
        return [
            // The component that will run in ../src/index.js
            'component' => 'k-lst-calendar-view',

            // the document title for the current view
            'title' => 'LST Calendar',

            // Declare props that will be passed to Vue
            'props' => [
                'slidesCollection' => function() {
                    $site = kirby()->site();
                    // Initialize empty files container
                    $allSlides = new Kirby\Cms\Files();

                    if ($targetPage = $site->find('slideshows')) {      // Replace slideshows with the page where galleries are located
                        $galleries = $targetPage->children()->filterBy('intendedTemplate', 'lst-gallery');
                        foreach ($galleries as $gallery) {
                            foreach ($gallery->files()->filterBy('template', 'lst-slide') as $slide) {
                                $allSlides->add($slide);
                            }
                        }
                    }

                    // Map collection to a clean array for Vue
                    return $allSlides->map(function($item) {
                        return [
                            'id' => $item->id(),
                            'title' => $item->filename(),
                            'image' => $item->url(),
                            'start' => $item->start()->value(),
                            'end' => $item->expire()->value(),
                            'tags' => $item->tags()->split(),
                            'url' => $item->panel()->url(),
                        ];
                    })->values();
                },

                'eventsCollection' => function() {
                    $site = kirby()->site();
                    // Initialize empty structure container
                    $allEvents = new Kirby\Cms\Structure();
                    if ($targetPage = $site->find('slideshows')) {      // Replace slideshows with the page where slideshows are located
                        $slideshowPages = $targetPage->children()->listed()->filterBy('intendedTemplate', 'lst-slideshow');

                        foreach ($slideshowPages as $slideshow) {
                            foreach ($slideshow->events()->toStructure() as $event) {
                                $allEvents->add($event);
                            }
                        }
                    }

                    // Map collection to a clean array for Vue
                    return $allEvents->map(function($item) {
                        return [
                            'id' => $item->id(),
                            'title' => $item->event()->value(),
                            'start' => $item->start()->value(),
                            'end' => $item->expire()->value(),
                            'url' => $item->parent()->panel()->url(),
                        ];
                    })->values();
                }
            ]
        ];
    }
];