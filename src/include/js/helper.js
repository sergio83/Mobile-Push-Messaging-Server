function refreshDevices(){
	$.ajax({

	    url : "ws.php?opc=devices",

        data :  {},
    
        type : 'GET',
    
        dataType : 'json',

        success : function(json) {	 
	    	 
	    	if(json.error!=undefined){
		       	return;
        	}
        	
	       	$("#devices").empty();			       	
	       	
	       	if(json.length>0){
	       	
	       		var code = "<table class='table table-bordered table-striped'><thead><tr><th style='width:18%;'>Create Date</th><th style='width:68%;'>ID</th><th style='width:14%;'>Device Type</th></tr></thead><tbody>"
		        code = code + "</tbody></table>"
		        $("#devices").append(code);
		        
		        code = "<div id='scroll_devices' class='scroll-content'>";
				code = code + "<table class='table table-bordered table-striped'><tbody>";
				for(var i=0; i<json.length;i++){
	              	var obj = json[i];
		          	var row = "<tr>";

	                row = row + "<td style='width:18%;  text-align:center;'>"+obj.date+"</td>";
	                row = row + "<td class='long-cell' style='width:68%;'>"+obj.id+"</td>";
	                row = row + "<td style='width:14%; text-align:center;'>"+obj.devicetype+"</td>";
	                row = row + "</tr>"; 
		            code = code + row;  
				}
				
				code = code + "</table></div>"
				$("#devices").append(code);
				adjustViewHeight();
				
				$("#scroll_devices").mCustomScrollbar({
			    	 scrollButtons:{
				    	 enable:true
				    	 }
				});	
				 
				$("#devices").show();
	    	 }else 	$("#devices").hide();	    	 

        },
        error : function(jqXHR, status, error) {

        },
        complete : function(jqXHR, status) {
        }
    }); 
}

function refreshMessages(){
	$.ajax({

	    url : "ws.php?opc=messages",

        data :  {},
    
        type : 'GET',
    
        dataType : 'json',

        success : function(json) {	 
	    	 
	    	if(json.error!=undefined){
		       	return;
        	}
        	
	       	$("#messages").empty();			       	
	       	
	       	if(json.length>0){
	       	
	       		var code = "<table class='table table-bordered table-striped'><thead><tr><th style='width:18%;'>Create Date</th><th style='width:68%;'>Message</th><th style='width:14%;'>Status</th></tr></thead><tbody>"
		        code = code + "</tbody></table>"
		        $("#messages").append(code);
		        
		        code = "<div id='scroll_messages' class='scroll-content'>";
				code = code + "<table class='table table-bordered table-striped'><tbody>";
				for(var i=0; i<json.length;i++){
	              	var obj = json[i];
		          	var row = "<tr>";

	                row = row + "<td style='width:18%;  text-align:center;'>"+obj.date+"</td>";
	                row = row + "<td style='width:68%;'>"+obj.message+"</td>";
	                row = row + "<td style='width:14%; text-align:center;'>"+obj.status+"</td>";
	                row = row + "</tr>"; 
		            code = code + row;  
				}
				
				code = code + "</table></div>"
				$("#messages").append(code);
				adjustViewHeight();
				
				$("#scroll_messages").mCustomScrollbar({
			    	 scrollButtons:{
				    	 enable:true
				    	 }
				});	
				 
				$("#messages").show();
	    	 }else 	$("#messages").hide();	    	 

        },
        error : function(jqXHR, status, error) {

        },
        complete : function(jqXHR, status) {
        }
    }); 
}

$("#send").click(function() {
	
	var to = "All";
	
	if($("#checkbox_iphone").is(':checked') && !$("#checkbox_android").is(':checked'))
		to= "Iphone";
	
	if(!$("#checkbox_iphone").is(':checked') && $("#checkbox_android").is(':checked'))
		to= "Android";
		
	if(($("#message").val()=="" && !$("#checkbox_fetch").is(':checked')) || (!$("#checkbox_iphone").is(':checked') && !$("#checkbox_android").is(':checked'))){
	alert("entro");
		return;
	}

//ws.php?opc=send&message=1234&to=All&update=false

	$.blockUI({ message: null });

	$.ajax({

	    url : "ws.php?opc=send&message="+$("#message").val()+"&to="+to+"&update="+$("#checkbox_fetch").is(':checked'),

        data :  {},
    
        type : 'GET',
    
        dataType : 'json',

        success : function(json) {	 
	    	 $("#message").val("");

        },
        error : function(jqXHR, status, error) {
	        alert("Error: "+error);
        },
        complete : function(jqXHR, status) {
         $.unblockUI();
         $("#message").val("");
        }
    }); 

});

function selectItemMenu(itemId){
	var ids = ["send_message","devices","messages"];
	
	for(var i=0;i<ids.length;i++){
		$("#menu_item_"+ids[i]).removeClass();
		$("#"+"content_"+ids[i]).css("display","none");
	}
	
	$("#menu_item_"+itemId).addClass("active");
	$("#"+"content_"+itemId).css("display","block");
	
	if(itemId=="devices")
		refreshDevices();
		
	if(itemId=="messages")	
		refreshMessages()
}

function adjustViewHeight(){
	  var h = $(window).height()-150; 
	  if(h<400){
	  	h=400;
	  	$("body").css("overflow","scroll");
	  }else $("body").css("overflow","hidden");
	  	
	  //$('#sectionContent').css("height",h+"px");

	  $('#devices').css("height",(h-140)+"px");
	  $('#scroll_devices').css("height",(h-200)+"px");	
	  
	  $('#messages').css("height",(h-140)+"px");
	  $('#scroll_messages').css("height",(h-200)+"px");		  
	  
}

$(window).resize(function() {
  adjustViewHeight();
});

$(window).load(function() {
	selectItemMenu("send_message");
	$("#content").show();
	refreshDevices();
	refreshMessages();
});