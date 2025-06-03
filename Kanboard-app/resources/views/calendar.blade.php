<x-app-layout>
    <x-slot name="header">
        <h2 class="text-2xl font-bold text-gray-800 dark:text-white">
            Calendrier
        </h2>
    </x-slot>

    <div class="max-w-7xl mx-auto px-4 py-6">
        <div id="calendar" class="bg-white rounded shadow p-4 dark:bg-gray-800"></div>
    </div>

    <!-- FullCalendar CSS & JS -->
    <link href="https://cdn.jsdelivr.net/npm/fullcalendar@6.1.8/index.global.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/fullcalendar@6.1.8/index.global.min.js"></script>

    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const calendarEl = document.getElementById('calendar');

            const calendar = new FullCalendar.Calendar(calendarEl, {
                initialView: 'dayGridMonth',
                locale: 'fr',
                height: 650,
                headerToolbar: {
                    left: 'prev,next today',
                    center: 'title',
                    right: 'dayGridMonth,timeGridWeek,listWeek'
                },
                events: [
                    // Exemple d'événements statiques
                    { title: 'Tâche A', start: '2025-06-02' },
                    { title: 'Deadline projet', start: '2025-06-04' },
                    { title: 'Réunion client', start: '2025-06-06T14:00:00' }
                ]
            });

            calendar.render();
        });
    </script>
</x-app-layout>
