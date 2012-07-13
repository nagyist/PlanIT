$(document).ready( function () {
	var tmpDate = new Date;
	var uniqid = tmpDate.getTime();
	var objmodal = new Array;
	
	$(".dialog").live( "click", function(e) {
		e.preventDefault();
		objmodal[uniqid] = $(this).attr("href");
		openDialog($(this).attr("href"),$(this).attr("title"),$(this).attr("rel"),uniqid);
		uniqid++;
		return false;
	});
	
	$(document).delegate('.ui-widget-overlay',"click", function() {
		$(".modals").last().dialog("close");
	}); 
	
	$(document).delegate(".datepick","focus", 
			function(e) { 
				$(this).datepicker({ 
					showOn: 'both', 
					dateFormat: 'yy-mm-dd' 
				}); 
			});
	$(document).delegate(".timepick","focus", 
			function(e) { 
				$(this).datetimepicker({ 
					showOn: 'both', 
					dateFormat: 'yy-mm-dd',
					timeFormat: 'hh:mm', 
					ampm:false, 
					hourMax:23 
				}); 
			});
	
	$(".submenu").css("visibility", "hidden");
	
	$("#project").mouseover(function(e) {$("#subproject").css("visibility","visible");});
	$("#team").mouseover(function(e) {$("#subteam").css("visibility","visible");});
	$("#task").mouseover(function(e) {$("#subtask").css("visibility","visible");});
	$("#charge").mouseover(function(e) {$("#subcharge").css("visibility","visible");});
	$("#feedback").mouseover(function(e) {$("#subfeedback").css("visibility","visible");});
	
	
	function openDialog(url, t, kind, id) {
		var button = {};
		if (kind == "help"){
			button = { "Close": function() { $(this).dialog("close"); } };
		} else {
			button = { "Save": function() { 
				$.ajax({
					type : "POST",
					url: $(".form").last().attr("action"),
					data: $(".form").last().serialize(),
					context: $(this),
					success: function(e) { 
						var errors = JSON.parse(e);
						if (errors.length > 0)	{
							var msg = '';
							for ( id in errors)	{
								msg += '<p>'+errors[id].field+' : '+errors[id].message+'</p>';
							}
							$('<div id="errors" style="display:none;">'+msg+'</div>').dialog({title:'Errors',modal:true, buttons: {Ok:function(){$(this).dialog("close");}}});
						}
						else
							$(this).dialog("close");	
					},
					error: function(xhr, status) { 
						$('<div id="errors" style="display:none;">Error while submitting form, please try again</div>').dialog({title:'Errors',modal:true, buttons: {Ok:function(){$(this).dialog("close");}}});
					}
				});
			} };
		}
		
		var dialog = $('<div class="modals" id="'+id+'" style="display:none;"></div>').appendTo("body");
		dialog.load(
			url,
			function( responseText, status, XmlHttpRequest ) {
				dialog.dialog({
					close: function(event, ui) {
						if ($('.modals').length > 1){
							$(".modals").slice(0,-1).each(function(i){
								$(this).load(objmodal[$(this).attr("id")]);
							});
						} 
						dialog.remove();
					},
					buttons: button,
					title:t,
					closeOnEscape: true,
					modal: true,
					minWidth: 800
				});
			}
		);
	}
	
});

