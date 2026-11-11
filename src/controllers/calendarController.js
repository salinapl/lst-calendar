// FullCalendar plugins
import themePlugin from "@fullcalendar/vue3/themes/forma"; // YOUR THEME
import dayGridPlugin from "@fullcalendar/vue3/daygrid";
import interactionPlugin from "@fullcalendar/vue3/interaction";

export default function useCalendarController(props, onEventClick){
    // Format slides and events collection for FullCalendar configuration
    const formattedEvents = props.slidesCollection.map(event => {
        return {
            title: event.title,
            image: event.image,
            start: event.start,
            end: event.end
        }
    });
    formattedEvents.push(...props.eventsCollection.map(event => {
        return {
            title: event.title,
            start: event.start,
            end: event.end
        }
    }));

    // Return the Calendar's configuration
    return{
        plugins: [themePlugin, dayGridPlugin, interactionPlugin],
        initialView: "dayGridMonth",
        headerToolbar: { 
            start: 'prev,next today',
            center: 'title',
            end: 'dayGridDay,dayGridWeek,dayGridMonth' 
        }, // buttons for switching between views
        displayEventEnd: true,

        /*
        // Optional: Specific options for each view
        views: {
            dayGridDay: {
            },
            dayGridWeek: {
            },
            dayGridMonth: {
            },
        }
        */

        events: formattedEvents,
        eventClick: onEventClick,
    }
}

