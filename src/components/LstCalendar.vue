<script setup>
    // FullCalendar app
    import FullCalendar from "@fullcalendar/vue3";

    // Stylesheets
    import '@fullcalendar/vue3/skeleton.css'; // ALWAYS NEED SKELETON
    import '@fullcalendar/vue3/themes/forma/theme.css'; // YOUR THEME
    import '@fullcalendar/vue3/themes/forma/palettes/blue.css'; // YOUR THEME'S PALETTE

    // Controllers
    import useCalendarController from '../controllers/calendarController.js';
    
    // Use computed for a dynamic calendar
    import { ref, computed, onMounted, onUnmounted } from "vue";

    // Load collections into props
    const props = defineProps({
        slidesCollection: Array,
        eventsCollection: Array
    });

    // Reactive state for the overlay
    const isOverlayOpen = ref(false);
    const overlayRef = ref(null);
    const selectedEvent = ref({
        title: '',
        url: '',
        image: '',
        start: '',
        end: ''
    });
    const overlayPosition = ref({ top: '0px', left: '0px' });


    // Function that is passed to controller
    function openOverlay(info) {
        info.jsEvent.preventDefault();
        info.jsEvent.stopPropagation();

        selectedEvent.value = {
            title: info.event.title,
            start: info.event.start || '',
            end: info.event.end || '',
            url: info.event.url || '',
            image: info.event.extendedProps?.image || '',
        };

        const rect = info.el.getBoundingClientRect();
        overlayPosition.value = {
            top: `${rect.bottom + window.scrollY + 6}px`,
            left: `${rect.left + window.scrollX}px`
        };

        isOverlayOpen.value = true;
    }

    function closeOverlay() {
        isOverlayOpen.value = false;
        selectedEvent.value.image = '';
    }

    // Pass openOverlay into the controller so eventClick can trigger it
    console.log('Loading calendar...');
    const calendarOptions = computed(() => {
        return useCalendarController(props, openOverlay);
    });
    console.log('Calendar load complete!');

    // Handle clicking outside the overlay
    function handleOutsideClick(e) {
        if (isOverlayOpen.value && overlayRef.value && !overlayRef.value.contains(e.target)) {
            closeOverlay();
        }
    }

    onMounted(() => {
        document.addEventListener('click', handleOutsideClick);
    });

    onUnmounted(() => {
        document.removeEventListener('click', handleOutsideClick);
    })
</script>

<template>
    <k-panel-inside>
        <k-header>LST Calendar</k-header>
        <FullCalendar :options="calendarOptions" />

        <!-- Event Overlay Window -->
        <div 
            v-if="isOverlayOpen"
            ref="overlayRef"
            id="lst-event-overlay" 
            class="lst-overlay"
            :style="overlayPosition"
        >
            <div class="lst-overlay-header">
                <h3 id="lst-overlay-title">{{ selectedEvent.title }}</h3>
                <div class="lst-overlay-actions">
                    <a v-if="selectedEvent.url" :href="selectedEvent.url" id="lst-overlay-link" target="_blank">To Page</a>
                    <button @click="closeOverlay" id="lst-overlay-close" aria-label="Close">&times;</button>
                </div>
            </div>
            <img v-if="selectedEvent.image" :src="selectedEvent.image" id="lst-overlay-image" alt=""></img>
            <p id="lst-overlay-text"><strong>Start:</strong> {{ selectedEvent.start.toLocaleString('en-US', {dateStyle: 'short', timeStyle: 'short'}) }}</p>
            <p id="lst-overlay-text"><strong>End:</strong> {{ selectedEvent.end.toLocaleString('en-US', {dateStyle: 'short', timeStyle: 'short'}) }}</p>
        </div>
    </k-panel-inside>   
</template>

<style>
    .lst-overlay {
        position: absolute;
        z-index: 1000;
        width: 260px;
        padding: 1rem;
        background: #ffffff;
        border: 1px solid #ddd;
        border-radius: 8px;
        box-shadow: 0 4px 12px rgba(0,0,0,0.15);
    }
    .lst-overlay-header {
        display: flex;
        justify-content: space-between;
        align-items: center;
        margin-bottom: 0.25rem;
    }
    .lst-overlay-header h3 {
        margin: 0;
        padding: 0.5rem 0;
        font-size: 1rem;
    }
    .lst-overlay-actions {
        display: flex;
        justify-content: flex-end;
        align-items: center;
        gap: 0.25rem;
    }
    #lst-overlay-link {
        padding: 0.5rem;
        border-radius: 5px;
        background-color: #0dcbff;
    }
    #lst-overlay-link:hover {
        background-color: color-mix(in srgb, #0dcbff 100%, #000000 10%);
    }
    #lst-overlay-close {
        padding: 0.5rem;
        background: none;
        border-radius: 5px;
        font-size: 1.25rem;
        cursor: pointer;
    }
    #lst-overlay-close:hover {
        background: color-mix(in srgb, #ffffff 100%, #000000 10%);
    }
    #lst-overlay-text {
        padding-top: 0.25rem;
        font-size: 1rem;
    }
</style>