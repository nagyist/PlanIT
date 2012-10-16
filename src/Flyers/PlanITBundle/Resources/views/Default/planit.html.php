<?php $view->extend('PlanITBundle::base.html.php') ?>

<?php $view['slots']->start('body') ?>
    	<div id="content">
	    	<div id="calendar"></div>
	    </div>
	    <script type="text/javascript">
		$('#calendar').fullCalendar({
			header: {
				left: 'prev,next today',
				center: 'title',
				right: 'month,agendaWeek,agendaDay'
			},
			events: "<?php echo $view['router']->generate('PlanITBundle_jsonevents'); ?>",
			axisFormat: 'HH(:mm)',
			timeFormat: 'H:mm',
			minTime: '08:00',
			maxTime: '20:00',
			height: 570,
			editable: true,
			theme: true,
			weekends: true,
			allDaySlot: false,
			defaultView: 'agendaWeek',
			eventDrop: function(event,dayDelta,minuteDelta,allDay,revertFunc) {
				$.ajax({
					type : "POST",
					url: '<?php echo $view['router']->generate('PlanITBundle_jsondrop'); ?>',
					data: {'id': event.id, 'start': event.start.toISOString(), 'end': event.end.toISOString() },
					error: function(xhr, status) { revertFunc(); }
				});
			},
			eventResize: function(event,dayDelta,minuteDelta,revertFunc) {
				$.ajax({
					type : "POST",
					url: '<?php echo $view['router']->generate('PlanITBundle_jsonresize'); ?>',
					data: {'id':event.id, 'end': event.end.toISOString()},
					error: function(xhr, status) { revertFunc(); }
				});
		    },
		    eventRender: function(event, element) {
		        element.qtip({
		            content: event.tooltip,
		            style: { 
						name: 'green',
						tip: 'bottomLeft',
					},
					position: {
						corner: {
							target: 'topLeft',
							tooltip: 'bottomLeft'
						}
					}
		        });	
		    }
		});
		</script>
<?php $view['slots']->stop() ?>