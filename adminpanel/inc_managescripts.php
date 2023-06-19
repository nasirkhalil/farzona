<link rel="stylesheet" type="text/css" href="<?=$conf->admin_url?>dist/css/jquery-ui.css"/>
<script src="<?=$conf->admin_url?>dist/js/jquery-ui.js"></script> 
<script language="javascript">
$(function () {
    
	$("#dialog-message").hide();
	$("#confirmation_dialog").hide();
	$("#confirmation_dialog_multi").hide();
     
	/*Hiding the div with ID dialog-message and #confirmation_dialog These 2 divs are responsible for the modal boxes .*/
   
	/* Function to Initialise a Dialog instance for the modal box */
	function modal_message()
	{
		
		$("#dialog-message").dialog({
			modal: true,
			buttons: {
			Ok: function() {
				$(this).dialog('destroy');
						
				}// OK function
			}
		});
	}
	
	function modal_message2()
	{
		
		$("#dialog-message2").dialog({
			modal: true,
			buttons: {
			Ok: function() {
				$(this).dialog('destroy');
						
				}// OK function
			}
		});
	}

	$('a.delete').click(function(e){ // if a user clicks on the "delete" image
	//e.preventDefault(); //prevent the default browser behavior when clicking   
	var row_id =     $(this).attr('id');
	var parent =   $(this).parent().parent().parent().parent().parent();
	//alert(row_id);
	$('#confirmation_dialog').dialog({ /*Initialising a confirmation dialog box (with  cancel/OK button)*/
					   
		autoOpen: false,
		width: 600,
		//position:[($(window).width() / 2) - (600 / 2), 200],
		buttons: {
			"Ok": function() { //If the user choose to click on "OK" Button
							   
				$(this).dialog('close'); // Close the Confirmation Box
							
				$.ajax({//make the Ajax Request
					type: 'get',
					url: '<? echo basename($_SERVER['PHP_SELF']);?>',
					data:'id=' + row_id,
					beforeSend: function() {
						parent.animate({'backgroundColor':'red'},100);
					},
					success: function(response) {//if the page ajax_delete.php returns the value "1"
						
						if(response==2){
							//parent.animate({'backgroundColor':'none'},100);							
							modal_message2();
							parent.on('click',function(){
								parent.animate({'backgroundColor':'none'},100);
							});							
						}else{
		
							parent.fadeOut(500,function() {//remove the Table row .
								parent.remove();
							});
						
							modal_message();//Display the success message in the modal box
						}
					}
				});
			}, 
			"Cancel": function() { //if the User Clicks the button "cancel"
				$(this).dialog('close');
			} 
		}
	});
	
	$('#confirmation_dialog').dialog('open');//Dispplay confirmation Dialogue when user clicks on "delete Image"          
		return false;
	}); // end a.delete
	
	// Here is the function for del multilevel
	$('.delmulti').click(function(e){ // if a user clicks on the "delete" image
	e.preventDefault(); //prevent the default browser behavior when clicking   
	var row_id=1;
	var allVals = [];
	var modal = false;
	$('#confirmation_dialog_multi').dialog({ /*Initialising a confirmation dialog box (with  cancel/OK button)*/
					   
		autoOpen: false,
		width: 600,
		//position:[($(window).width() / 2), 200],
		buttons: {
		"Ok": function() { //If the user choose to click on "OK" Button
			$(this).dialog('close'); // Close the Confirmation Box
			$('#frm .case').each(function() {
				if ($(this).is(':checked')) {
					var parent = $(this).parent().parent();
					var qry =  $(this).val();
					$.post("<? echo basename($_SERVER['PHP_SELF']);?>", {multidelete:1, checkbox:qry },			
					function(response) {
						
						if(response==2){
							//if(modal===false){
								modal_message2();
								modal = true;
							//}
							parent.animate({'backgroundColor':'#FF3333'},100);							
							parent.on('click',function(){
								parent.animate({'backgroundColor':'none'},100);
							});							
						}
						if(response==1){
							if(modal===false){
								modal_message();
								modal = true;
							}
							parent.animate({'backgroundColor':'red'},100);
							parent.fadeOut('slow');							
						}
					});					
				}
			});
	
		}, // button ok ends here
		"Cancel": function() { //if the User Clicks the button "cancel"
				$(this).dialog('close');
		} 
	}
});
	
$('#confirmation_dialog_multi').dialog('open');//Dispplay confirmation Dialogue when user clicks on "delete Image"
	return false;
	});
	///// Here it ends for multilevel deletion
	
	$('a.view').click(function(e){ // if a user clicks on the "delete" image
	//e.preventDefault(); //prevent the default browser behavior when clicking   
	var view_id =     $(this).attr('id');
	
	//alert(row_id);
	$('#view_dialog').dialog({ /*Initialising a confirmation dialog box (with  cancel/OK button)*/
					   
		modal: true,
		autoOpen: false,
		width: widthofwin(),
		position: { my: 'top', at: 'top+50+'+getPageScroll()[1]+'' },
		
		open: function(event, ui){			
			$("#viewdets").load('view<?=$pagetype?>.php?id='+view_id);			
			$(".ui-dialog-titlebar-close", ui.dialog | ui).hide();
		},
		buttons: {
			Close: function() {
				$(this).dialog('destroy');
						
			}// Close function
		}		
	});
	
	$('#view_dialog').dialog('open');//Dispplay confirmation Dialogue when user clicks on "delete Image"          
		return false;
	}); // end a.delete		
});// end document.ready
// function for returning width and height of window //
function widthofwin(){
	var width = $(window).width(), height = $(window).height();
	var ret;
	if ((width <= 767) && (height >= 1025)) {
		ret = width;
	} else if ((width == 768)) {
		ret = "500";
	} else{
		ret = "600";		
	}
	return ret;
}

function getPageScroll() {
    var xScroll, yScroll;
    if (self.pageYOffset) {
      yScroll = pageYOffset;
      xScroll = pageXOffset;
    } else if (document.documentElement && document.documentElement.scrollTop) {     // Explorer 6 Strict
      yScroll = document.documentElement.scrollTop;
      xScroll = document.documentElement.scrollLeft;
    } else if (document.body) {// all other Explorers
      yScroll = document.body.scrollTop;
      xScroll = document.body.scrollLeft;    
    }    
    return new Array(xScroll,yScroll) 
}
</script>  
<script>
$(function () {
	$('#example1').DataTable( {
    "aoColumnDefs": [
      { "bSortable": false, "aTargets": [ "no-sort" ] }
    ] } );
	$('.no-sort').removeClass('sorting_asc');
});
</script> 
<script language="javascript">
$(function () {
    // add multiple select / deselect functionality
    $("#selectall").click(function () {
		
        $('.case').prop('checked', this.checked);
    });
 
    // if all checkbox are selected, check the selectall checkbox
    // and viceversa
    $(".case").click(function(){
 
        if($(".case").length == $(".case:checked").length) {
            $("#selectall").prop("checked", "checked");
        } else {
            $("#selectall").removeAttr("checked");
        }
    });
});
</script>