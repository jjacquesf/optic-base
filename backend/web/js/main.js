
function init_daterangepicker_right() {
  
	if( typeof ($.fn.daterangepicker) === 'undefined'){ return; }
	
	var cb = function(start, end, label) {
	  console.log(start.toISOString(), end.toISOString(), label);
	  $('#reportrange_right span').html(start.format('D MMMM, YYYY') + ' - ' + end.format('D MMMM, YYYY'));
	};

	var optionSet1 = {
	  startDate: moment().subtract(29, 'days'),
	  endDate: moment(),
	  minDate: '01/01/2012',
	  maxDate: '12/31/2020',
	  dateLimit: {
		days: 60
	  },
	  showDropdowns: true,
	  showWeekNumbers: true,
	  timePicker: false,
	  timePickerIncrement: 1,
	  timePicker12Hour: true,
	  ranges: {
		'Hoy': [moment(), moment()],
		'Ayer': [moment().subtract(1, 'days'), moment().subtract(1, 'days')],
		'Últimos 7 días': [moment().subtract(6, 'days'), moment()],
		'Últimos 30 días': [moment().subtract(29, 'days'), moment()],
		'Mes actual': [moment().startOf('month'), moment().endOf('month')],
		'Mes anterior': [moment().subtract(1, 'month').startOf('month'), moment().subtract(1, 'month').endOf('month')]
	  },
	  opens: 'right',
	  buttonClasses: ['btn btn-default'],
	  applyClass: 'btn-small btn-primary',
	  cancelClass: 'btn-small',
	  format: 'DD/MM/YYYY',
	  separator: ' a ',
	  locale: {
		applyLabel: 'Confirmar fechas',
		cancelLabel: 'Limpiar fechas',
		fromLabel: 'De',
		toLabel: 'A',
		customRangeLabel: 'Personalizar rango',
		daysOfWeek: ['Do', 'Lu', 'Ma', 'Mi', 'Ju', 'Vi', 'Sa'],
		monthNames: ['Enero', 'Febrero', 'Marzo', 'Abril', 'Mayo', 'Junio', 'Julio', 'Agosto', 'Septiembre', 'Octubre', 'Noviembre', 'Diciembre'],
		firstDay: 1
	  }
	};

	$('#reportrange_right span').html(moment().subtract(29, 'dias').format('D MMMM, YYYY') + ' - ' + moment().format('D MMMM, YYYY'));

	$('#reportrange_right').daterangepicker(optionSet1, cb);

	// $('#reportrange_right').on('show.daterangepicker', function() {
	//   console.log("show event fired");
	// });
	// $('#reportrange_right').on('hide.daterangepicker', function() {
	//   console.log("hide event fired");
	// });
	// $('#reportrange_right').on('apply.daterangepicker', function(ev, picker) {
	//   console.log("apply event fired, start/end dates are " + picker.startDate.format('D MMMM, YYYY') + " a " + picker.endDate.format('D MMMM, YYYY'));
	// });
	// $('#reportrange_right').on('cancel.daterangepicker', function(ev, picker) {
	//   console.log("cancel event fired");
	// });
}

function init_SmartWizard() {
	
	// if( typeof ($.fn.smartWizard) === 'undefined'){ return; }
	// console.log('init_SmartWizard');
	
	// $('#wizard').smartWizard();

	// $('#wizard_verticle').smartWizard({
	//   transitionEffect: 'slide'
	// });

	// $('.buttonNext').addClass('btn btn-success');
	// $('.buttonPrevious').addClass('btn btn-primary');
	// $('.buttonFinish').addClass('btn btn-default');
	
};

function init_clockpicker() {
	$(".clockpicker").clockpicker({ donetext: "Hecho" });
};

function init() {
	$.each($('.dependant'), function(i,o) {
		
		var dependant = this;
		var field = $(o).data('field');
		var value = $(o).data('value');
		var action = $(o).data('action');

		switch(action) 
		{
			case 'hide':

				if($(field).val() == value) {
					$(o).addClass("d-none");
				} else {
					$(o).removeClass("d-none");
				}

				$(field).on('change', function(e) {
					if($(this).val() == value) {
						$(dependant).addClass('d-none');
					} else {
						$(dependant).removeClass('d-none');
					}
				});

				break;

			case 'show':
			default:

				if($(field).val() == value) {
					$(o).removeClass("d-none");
				} else {
					$(o).addClass("d-none");
				}

				$(field).on('change', function(e) {
					if($(this).val() == value) {
						$(dependant).removeClass('d-none');
					} else {
						$(dependant).addClass('d-none');
					}
				});

				break;
		}
	});
}

$(document).ready(function() {
	init_daterangepicker_right();
	init_SmartWizard();
	init_clockpicker();

	init();
});		