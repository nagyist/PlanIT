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
			height: 550,
			editable: true,
			theme: true,
			weekends: true,
			allDaySlot: false,
			defaultView: 'agendaDay',
			eventDrop: function(event,dayDelta,minuteDelta,allDay,revertFunc) {
				$.ajax({
					type : "POST",
					url: '<?php echo $view['router']->generate('PlanITBundle_jsondrop'); ?>',
					data: {'id': event.id, 'start': event.start.toString(), 'end': event.end.toString() },
					error: function(xhr, status) { revertFunc(); }
				});
			},
			eventResize: function(event,dayDelta,minuteDelta,revertFunc) {
				$.ajax({
					type : "POST",
					url: '<?php echo $view['router']->generate('PlanITBundle_jsonresize'); ?>',
					data: {'id':event.id, 'end': event.end.toString()},
					error: function(xhr, status) { revertFunc(); }
				});
		    }
		});
		</script>
<?php $view['slots']->stop() ?>