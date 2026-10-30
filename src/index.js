import LstCalendar from "./components/LstCalendar.vue";
panel.plugin('salinapl/lst-calendar', {
    // Declare what components will route to when they are called
    components: {
        'k-lst-calendar-view': LstCalendar
    },
});