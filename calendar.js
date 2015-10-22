/**************************************
 TITLE: calendar.js
 AUTHOR: Chris Antolin
 CREATE DATE: 10/21/15
 PURPOSE: Creates our calendar using our jquery plug-in
 LAST MODIFIED ON: 
 LAST MODIFIED BY:
 MODIFICATION HISTORY: Update Changelog
*/

/*Note: Make sure you use the Save as and not overwrite this original file!*/

$(document).ready(function(){
		$('#calendar').fullCalendar({
			header: {
				left: 'prev,next today', //applies the buttons into the system 
				center: 'title', //displays the current month/year
				right: 'month,agendaWeek,agendaDay'  //buttons for the calendar views
			},
			defaultDate: Date(),
			editable: false,  //allows the user to edit the time and day - does not stay...YET
			businessHours: true, //This will gray out times that are not considered 'business hours'
			events: [
				{
					id: 2,    // id can be given to the event, not sure entirely what it's purpose is yet
					title: 'Prototype Presentation 2', // title of the event that will show on the page - can have the event location
					start: '2015-10-22T10:30:00', //when the event starts Year-Month-Day T(time - Standard 24hour) Hour-Minute-Second
					end: '2015-10-22T11:45:00'  //when the event ends Year-Month-Day T(time - Standard 24hour) Hour-Minute-Second
				},
				{
					title: 'Conference',
					start: '2015-02-11',
					end: '2015-02-13'
				},
				
				//Show availability based on holidays
				{
					start: '2015-12-25',
					overlap: false,
					rendering: 'background',
					color: '#ff9f89'					
				}
			]
		});	
});