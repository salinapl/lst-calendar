<?php

Kirby::plugin('salinapl/lst-calendar',
    [
        'sections' => [
            'vue-section' => [
                'props' => [
                    'slidesCollection' => function($site) {
                        // Initialize empty files container
                        $allSlides = new Kirby\Cms\Files();

                        if ($targetPage = $site->find('slideshows')) {      // Replace slideshows with the page where galleries are located
                            foreach ($targetPage->slideGalleries()->toPages() as $gallery) {
                                foreach ($gallery->slides() as $slide) {
                                    $allSlides->add($slide);
                                }
                            }
                        }

                        // Map collection to a clean array for Vue
                        return $allSlides->map(function($item) {
                            return [
                                'id' => $item->id(),
                                'title' => $item->title()->value(),
                                'image' => $item->image() ? $item->image()->url() : null,
                                'start' => $item->start(),
                                'expire' => $item->expire(),
                                'tags' => $item->tags(),
                            ];
                        })->values();
                    },
                    
                    'eventsCollection' => function($site) {
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

                        // Map collection to a clean array for Vue
                        return $allEvents->map(function($item) {
                            return [
                                'id' => $item->id(),
                                'event' => $item->title()->value(),
                                'start' => $item->start(),
                                'expire' => $item->expire(),
                            ];
                        })->values();
                    }
                ]
            ]
        ]
    ]
);