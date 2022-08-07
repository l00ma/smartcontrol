(function($){
// fonctions

var data_temp;


function loadValues_int () {
	$.ajax({ 
		type:'get', 
		async: false,
		url: 'includes/load_temp.php',
		dataType: 'json',
		success: function(result){
			data_temp = JSON.parse(result);
		}
	});
}
//fonction trace le graph
function graph () {
			Highcharts.setOptions({ 
				lang: {
					months: ['Janvier', 'Février', 'Mars', 'Avril', 'Mai', 'Juin',  'Juillet', 'Août', 'Septembre', 'Octobre', 'Novembre', 'Décembre'],
					shortMonths: ['Jan', 'Fév', 'Mar', 'Avr', 'Mai', 'Jun',  'Jui', 'Aoû', 'Sep', 'Oct', 'Nov', 'Déc'],
					weekdays: ['Dimanche', 'Lundi', 'Mardi', 'Mercredi', 'Jeudi', 'Vendredi', 'Samedi'],
					loading: 'Chargement...'
				},
				chart: {
				spacingBottom: 40,
					style: {
						fontFamily: 'Trebuchet, Arial, sans-serif',
						color: '#727272'
					}
				},
				title: {
					style: {
						color: '#727272'
					}
				},
				global: {
					useUTC: false
				},
				colors: ['#2137ff', '#1929bf', '#101b80'],
			});
			$('#container_mouv_temp').highcharts('StockChart', {
				title: { text: 'Historique des températures sur le dernier mois' },
				exporting: 'false',
				xAxis: { 
				    gapGridLineWidth: 0,
					lineColor: '#727272'
				},
				plotOptions: {
					series: {
					 dataGrouping: {
						 dateTimeLabelFormats: {
							   minute: ['%A %e %B, %H:%M', '%A %e %B, %H:%M', '-%H:%M'],
							   hour: ['%A %e %B, %H:%M', '%A %e %B, %H:%M', '-%H:%M'],
							   day: ['%A %e %B %Y', '%A %e %B', '-%A %e %B %Y'],
							   week: ['Semaine du %A %e %B %Y', '%A %e %B', '-%A %e %B %Y'],
							   month: ['%B %Y', '%B', '-%B %Y'],
							   year: ['%Y', '%Y', '-%Y']
							},
					 },
					    lineWidth: 2,
					    states: {
						hover: {
						    enabled: true,
						    lineWidth: 3 // largeur de la ligne quand hovered
						}
					    }
				    },
				},
				yAxis: { 
					tickPositioner: function () {
						var positions = [],
						tick = Math.floor(this.dataMin),
						increment = Math.ceil((this.dataMax - this.dataMin) / 6);
						for (tick; tick - increment <= this.dataMax; tick += increment) {
							positions.push(tick);
						}
						return positions;
						},
						offset: 30,
						labels: {
							format: '{value}°c'
						}
					},
				rangeSelector : {
					buttonTheme: { // styles for the buttons
						fill: 'none',
						stroke: 'none',
						'stroke-width': 0,
						r: 8,
						states: {
						    hover: {
						    },
						    select: {
							fill: '#bbe2de',
						    }
						}
					},
					buttons : [{
					    type : 'hour',
					    count : 1,
					    text : '1h'
					}, {
					    type : 'hour',
					    count : 12,
					    text : '12h'
					},{
					    type : 'day',
					    count : 1,
					    text : '1j'
					}, {
					    type : 'day',
					    count : 7,
					    text : '7j'
					}, {
					    type : 'day',
					    count : 15,
					    text : '15j'
					}, {
					    type : 'all',
					    count : 1,
					    text : 'tout'
					}],
					// se positionne pa defaut sur 1 jour
					selected : 2,
					inputEnabled : false
				},
				series : [{
					name : 'T° Int',
					type: 'areaspline',
					data : data_temp.data_int,
					gapSize: 0,
					tooltip: {
						valueDecimals: 1,
						valueSuffix: '°c',
						xDateFormat: '%A %e %B à %H:%M'//format date dans l'infobulle (voir http://php.net/manual/en/function.strftime.php)
					},
					fillColor : {
					    linearGradient : {
						x1: 0,
						y1: 0,
						x2: 0,
						y2: 1
					    },
					    stops : [
						[0, Highcharts.getOptions().colors[0]],
						[1, Highcharts.Color(Highcharts.getOptions().colors[0]).setOpacity(0).get('rgba')]
					    ]
					},
					threshold: 0
				},
				{
					name : 'T° Bas',
					type: 'areaspline',
					data : data_temp.data_bas,
					gapSize: 0,
					tooltip: {
						valueDecimals: 1,
						valueSuffix: '°c',
						xDateFormat: '%A %e %B à %H:%M'//format date dans l'infobulle (voir http://php.net/manual/en/function.strftime.php)
					},
					fillColor : {
					    stops : [
						[0, Highcharts.getOptions().colors[1]],
					    ]
					},
					threshold: 0
				},
				{
					name : 'T° Ext',
					type: 'areaspline',
					data : data_temp.data_ext,
					gapSize: 0,
					tooltip: {
						valueDecimals: 1,
						valueSuffix: '°c',
						xDateFormat: '%A %e %B à %H:%M'//format date dans l'infobulle (voir http://php.net/manual/en/function.strftime.php)
					},
					fillColor : {
					    stops : [
						[0, Highcharts.getOptions().colors[2]],
					    ]
					},
					threshold: 0
				}],
				navigator: {
					series: {
						color: '#2137ff',
						lineWidth: 1
					},
					xAxis: { 
						lineColor: '#727272',
						dateTimeLabelFormats: { day: '%d/%m'} //format date dans le navigator
					}
				}
			});
}

// actions
$(document).ready (function () {
	loadValues_int ()
	graph ();
	setInterval(function() { loadValues_int (); graph (); } ,300000);

	//boutons en haut à droite
	$('#but_menu').click(function() {
		location.href='welcome.php';
	});
	$('#but_logout').click(function() {
		location.href='includes/logout.php';
	});
});

})( jQuery );