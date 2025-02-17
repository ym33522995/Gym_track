import axios from "axios";
import { Calendar } from "@fullcalendar/core";
import dayGridPlugin from "@fullcalendar/daygrid";
import timeGridPlugin from '@fullcalendar/timegrid';

// console.log("calendar.js is loaded and running");

const calendarEl = document.getElementById("calendar");

if (calendarEl) {
    axios.get("/calendar/record-dates")
        // .then((response) => {
        //     console.log("API Response:", response.data);
        // })
        .then((response) => {
            const recordDates = response.data;
            console.log("Record Dates:", recordDates);

            const calendar = new Calendar(calendarEl, {
                plugins: [dayGridPlugin, timeGridPlugin],
                initialView: "dayGridMonth",
                headerToolbar: {
                    start: "prev,next today",
                    center: "title",
                    end: "dayGridMonth,timeGridWeek",
                },
                height: "auto",
                dayCellDidMount: function (info) {
                    const date = new Date(info.date.getTime() + 9 * 60 * 60 * 1000).toISOString().split("T")[0]
                    if (recordDates.includes(date)) {
                        info.el.style.backgroundColor = "#52057B"; //#52be80
                        info.el.style.color = "#FFFFFF";
                    }
                }
            });

            calendar.render();
        })
        .catch((error) => {
            console.error("Error fetching record dates:", error);
        });
}