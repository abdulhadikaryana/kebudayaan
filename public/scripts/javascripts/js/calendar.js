$(document).ready(function() {
	
		var date = new Date();
		var d = date.getDate();
		var m = date.getMonth();
		var y = date.getFullYear();
		
		$('#calendar').fullCalendar({
			header: {
				left: 'prev,next today',
				center: 'title',
				right: 'month,agendaWeek,agendaDay'
			},
			editable: true,
			events: [
				{
					title: 'Pameran Keris Pusaka Indonesia',
					start: new Date(y, m, 1)
				},
				{
					title: 'Upacara Candi Borobudur',
					start: new Date(y, m, d-5),
					end: new Date(y, m, d-2)
				},
				{
					id: 999,
					title: 'Lomba Tari Saman ITB',
					start: new Date(y, m, d-3, 16, 0),
					allDay: false
				},
				{
					id: 999,
					title: 'Lomba Tari Saman ITB',
					start: new Date(y, m, d+4, 16, 0),
					allDay: false
				},
				{
					title: 'Upacara Ngaben',
					start: new Date(y, m, d, 10, 30),
					allDay: false
				},
				{
					title: 'Bali Festival',
					start: new Date(y, m, d, 12, 0),
					end: new Date(y, m, d, 14, 0),
					allDay: false
				},
				{
					title: 'Pameran Lukisan Effendi',
					start: new Date(y, m, d+1, 19, 0),
					end: new Date(y, m, d+1, 22, 30),
					allDay: false
				},
				{
					title: 'Pertunjukan Barongsai',
					start: new Date(y, m, 28),
					end: new Date(y, m, 29),
					url: 'http://google.com/'
				}
			]
		});
		
	});
