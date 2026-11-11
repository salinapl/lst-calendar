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
    import { computed } from "vue";

    console.log('Loading calendar...');
    const calendarOptions = computed(() => {
        return useCalendarController(props);
    });
    console.log('Calendar load complete!');

    // Load collections into props
    const props = defineProps({
        slidesCollection: Array,
        eventsCollection: Array
    });
</script>

<template>
    <k-panel-inside>
        <k-header>LST Calendar</k-header>
        <FullCalendar :options="calendarOptions" />
    </k-panel-inside>   
</template>