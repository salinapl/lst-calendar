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
                        [
                            // the Panel patterns must not start with 'panel/',
                            // the `panel` slug is automatically prepended.
                            'pattern' => 'lst-calendar',
                            'action'  => function () {

                                // view routes return a simple array,
                                // which will be injected into our Vue app;
                                // the array can control the loaded Vue component,
                                // props for the component and settings for the current view
                                // (like breadcrumb, title, active search type etc.)

                                return [
                                    // the Vue component can be defined in the
                                    // `index.js` of your plugin
                                    'component' => 'lst-calendar',

                                    // the document title for the current view
                                    'title' => 'LST Calendar',

                                    // props will be directly available in the
                                    // Vue component. It's a super convenient way
                                    // to send backend data to the Panel
                                    'props' => [
                                        'slidesCollection' => function() {
                                            $site = kirby()->site();
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
                                                    'image' => $item->image()?->url(),
                                                    'start' => $item->start()->value(),
                                                    'expire' => $item->expire()->value(),
                                                    'tags' => $item->tags()->split(),
                                                ];
                                            })->values();
                                        },

                                        'eventsCollection' => function() {
                                            $site = kirby()->site();
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
                                                    'event' => $item->event()->value(),
                                                    'start' => $item->start()->value(),
                                                    'expire' => $item->expire()->value(),
                                                ];
                                            })->values();
                                        }
                                    ]
                                ];
                            }
                        ]
                    ]
                ];
            }
            
        ]
    ]
);