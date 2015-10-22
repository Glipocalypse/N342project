/**************************************
 TITLE: stats.js
 AUTHOR: Chris Antolin
 CREATE DATE: 10/21/15
 PURPOSE: Creates and handles Stats in Area
 LAST MODIFIED ON: 
 LAST MODIFIED BY: 
 MODIFICATION HISTORY: 
*/

/*Note: Make sure you use the Save as and not overwrite this original file!*/

$(document).ready(function(){
			
			//Create Circle Graphs using Morris.js
			Morris.Donut({
				element: 'SalesEx',
				resize: true,
				data: [
				{label: "Type A", value: 10},
				{label: "Type B", value: 30},
				{label: "Type C", value: 20},
				{label: "Type D", value: 40}
				]
			});
			
			Morris.Donut({
				element: 'SalesStat',
				resize: true,
				data: [
				{label: "Completed", value: 67},
				{label: "In Progress", value: 53},
				{label: "To Complete", value: 40}
				]
			});
			
			//Morris.js Line Graph
			Morris.Line({
			  element: 'ProgLine',
			  data: [
				{ y: '2006', a: 100},
				{ y: '2007', a: 120},
				{ y: '2008', a: 150},
				{ y: '2009', a: 195},
				{ y: '2010', a: 176},
				{ y: '2011', a: 164},
				{ y: '2012', a: 203},
				{ y: '2013', a: 216},
				{ y: '2014', a: 196},
				{ y: '2015', a: 160}
			  ],
			  xkey: 'y',
			  ykeys: ['a'],
			  labels: ['Sales by Year-end']
			});


			
});