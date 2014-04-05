
<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <title>Push Notification</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="">
    <meta name="author" content="">

    <!-- HTML5 shim, for IE6-8 support of HTML5 elements -->
    <!--[if lt IE 9]>
      <script src="../assets/js/html5shiv.js"></script>
    <![endif]-->

    <!-- Fav and touch icons -->
    <link rel="apple-touch-icon-precomposed" sizes="144x144" href="../assets/ico/apple-touch-icon-144-precomposed.png">
    <link rel="apple-touch-icon-precomposed" sizes="114x114" href="../assets/ico/apple-touch-icon-114-precomposed.png">
    <link rel="apple-touch-icon-precomposed" sizes="72x72" href="../assets/ico/apple-touch-icon-72-precomposed.png">
    <link rel="apple-touch-icon-precomposed" href="../assets/ico/apple-touch-icon-57-precomposed.png">
    <link rel="shortcut icon" href="../assets/ico/favicon.png">
    
    <style type="text/css">
      body {
        padding-top: 60px;
        padding-bottom: 40px;
      }
      .sidebar-nav {
        padding: 9px 0;
      }

      @media (max-width: 980px) {
        /* Enable use of floated navbar text */
        .navbar-text.pull-right {
          float: none;
          padding-left: 5px;
          padding-right: 5px;
        }
      }
    </style>    
    
        <!-- CSS -->
    <link href="include/bootstrap/css/bootstrap.min.css" rel="stylesheet">
    <link href="include/css/style.css" rel="stylesheet">   
    <link href="include/css/jquery.mCustomScrollbar.css" rel="stylesheet">
  </head>

  <body>

    <div class="navbar navbar-inverse navbar-fixed-top">
      <div class="navbar-inner">
        <div class="container-fluid">
          <a class="brand" href="#">Push Notification</a>
        </div>
      </div>
    </div>

    <div class="container-fluid">
      <div class="row-fluid">
        <div class="span3">
          <div class="well sidebar-nav">
            <ul class="nav nav-list">
              <li class="nav-header">Index</li>
              <li id="menu_item_send_message" class="active"><a href="javascript:selectItemMenu('send_message')">Send Message</a></li>
              <li id="menu_item_devices"><a href="javascript:selectItemMenu('devices')">Devices</a></li>
              <li id="menu_item_messages"><a href="javascript:selectItemMenu('messages')">Messages</a></li>
            </ul>
          </div><!--/.well -->
        </div><!--/span-->
        <div class="span9">
          <div id="content" style="display:none;" class="hero-unit">
	          <div id="content_send_message">
	    
				    <label>Message:</label>
				    <textarea id="message" rows="3"></textarea>
				    <span class="help-block"></span>
				    <div class="row-fluid">
				    	<div id="checkbox_device" class="span11">
						<label class="checkbox inline">
						  <input id="checkbox_fetch" type="checkbox" value="1">
						  Update the application content (Only for iPhone)
						</label>
						</div>	
					</div>	
				    <div class="row-fluid">
				    <div id="checkbox_device" class="span11">
						<label class="checkbox inline">
						  <input id="checkbox_iphone" type="checkbox" checked value="1">
						  Iphone
						</label>
						<label class="checkbox inline">
						  <input id="checkbox_android" type="checkbox" checked value="1">
						  Android
						</label>
					</div>					
					<div class="span1">				
					    <button id="send" type="submit"  class="btn btn-primary">Send</button>
				    </div>
				   </div>  
				
	          </div>
	          <div id="content_devices">
		          <h3>Devices:</h3>
		          <div id="devices"></div>
	          </div>
	          <div id="content_messages">
		        <h3>Messages:</h3>
	          	<div id="messages"></div>
	          </div>                    
          </div>
                   
        </div><!--/span-->
      </div><!--/row-->

    </div><!--/.fluid-container-->

    <!-- Le javascript
    ================================================== -->
    <!-- Placed at the end of the document so the pages load faster -->
    <script src="http://code.jquery.com/jquery-1.9.1.min.js"></script> 
    <script src="include/js/jquery.mCustomScrollbar.min.js"></script>
    <script src="include/bootstrap/js/bootstrap.min.js"></script>
    <script src="include/js/jquery.blockUI.js"></script>    
    <script src="include/js/helper.js"></script>    
    
  </body>
</html>
