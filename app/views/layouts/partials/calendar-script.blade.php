<script type="text/javascript" language="javascript" src="{{ url('calendar/lib/moment.min.js')}}"></script>
<script type="text/javascript" language="javascript" src="{{ url('calendar/lib/jquery-ui.custom.min.js')}}"></script>
<script type="text/javascript" language="javascript" src="{{ url('calendar/lang/de.js')}}"></script>
<script type="text/javascript" language="javascript" src="{{ url('calendar/fullcalendar.js')}}"></script>
<link rel="stylesheet" type="text/css" href="{{ url('calendar/fullcalendar.css')}}">
<script type="text/javascript" class="init">
	$(document).ready(function() {

	    // page is now ready, initialize the calendar...

	    $('#calendar').fullCalendar({
	        // put your options and callbacks here
	        header: {
				left: '',
				center: '',
				right: ''
			},
	        lang: 'de',
	    	defaultView: 'agendaWeek',
	    	editable: false,
	    	minTime: "08:00:00",
	    	maxTime: "20:00:00",
	    	axisFormat: 'HH:mm',
	    	allDaySlot: false,
	    	timezone: "Europe/Berlin",
	    	columnFormat: "dddd",
	    	weekends: ({{$weekends}} == false) ? false : true ,
	    	slotEventOverlap: true,
	    	events: {{ json_encode($output) }}
	    });

	});

</script>