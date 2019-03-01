<!DOCTYPE html>
<html>
   <head>
      <meta name="viewport" content="width=device-width, initial-scale=1">
      <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.0/css/bootstrap.min.css">
      <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
      <script src="https://code.jquery.com/jquery-3.3.1.min.js" integrity="sha256-FgpCb/KJQlLNfOu91ta32o/NMZxltwRo8QtmkMRdAu8=" crossorigin="anonymous"></script>
      <script src="https://code.jquery.com/ui/1.12.1/jquery-ui.min.js" integrity="sha256-VazP97ZCwtekAsvgPBSUwPFKdrwD3unUfSGVYrahUqU=" crossorigin="anonymous"></script>
      <style>
         body{
         background-color:#dcc8b2;
         }
         .todolist{
         background-color:#FFF;
         padding:20px 20px 10px 20px;
         margin-top:30px;
         }
         .todolist h1{
         margin:0;
         padding-bottom:20px;
         text-align:center;
         }
         .form-control{
         border-radius:0;
         }
         li.ui-state-default{
         background:#fff;
         border:none;
         border-bottom:1px solid #ddd;
         }
         li.ui-state-default:last-child{
         border-bottom:none;
         }
         .todo-footer{
         background-color:#F4FCE8;
         margin:0 -20px -10px -20px;
         padding: 10px 20px;
         }
         #done-items li{
         padding:10px 0;
         border-bottom:1px solid #ddd;
         text-decoration:line-through;
         }
         #done-items li:last-child{
         border-bottom:none;
         }
         #checkAll{
         margin-top:10px;
         }
      </style>
   </head>
   <body>
      <h1>
         <center>SHOPPING LIST</center>
      </h1>
      <div class="container">
         <div class="row">
            <div class="col-md-12">
               <div class="todolist not-done">
                  <input type="text"  id="user_input_val"  class="form-control add-todo" maxlength="100" placeholder="What's In your Mind?">
                  <hr>
                  <div id="list_frame" name="list_frame"></div>
                  <div class="todo-footer">
                     <strong><span class="count-todos"></span></strong> Items Left :<span id="itemcount"></span>
                  </div>
               </div>
            </div>
         </div>
      </div>
   </body>
</html>
<script type="text/javascript">
   $(":input").bind("keyup", function(e) {
   var inputVal = $(this).val();
   if(inputVal.match(/[^-A-Za-z0-9._ ]/)){
     // there is a mismatch, hence show the error message
   	 alert( "you have entered invalid data");
   	 return false;
   	 $( "#user_input_val" ).focus();
    }		   
   });
   $(document).ready(function(){
   	$.ajax({
   		 url  : '/todolist/todoajax.php',
   		 type : "POST",
   		 cache : false,
   		 data : {key:'show'},
   		 success : function(data){
   			 var data_split = data.split("~~");
   			$('#list_frame').html(data_split[0]);
   			$('#itemcount').html(data_split[1]);
   		 }
   	});
   });
   $(document).on("keypress", "input", function(e){
   	if(e.which == 13){
   		var inputVal = $(this).val();
   		if(inputVal !="" && inputVal!=null){
   			if(inputVal.match(/[^-A-Za-z0-9._ ]/)){
   			  // there is a mismatch, hence show the error message
   				 alert( "you have entered an invalid input" );
   				 return false;
   				$( "#user_input_val" ).focus();
   			}else{
   				$.ajax({
   				 url  : '/todolist/todoajax.php',
   				 type : "POST",
   				 cache : false,
   				 data : {inputVal:inputVal,key:'insert'},
   				 success : function(data){
   					 var data_split = data.split("~~");
   					$('#list_frame').html(data_split[0]);
   					$('#itemcount').html(data_split[1]);
   				 }
   				});
   			}
   		}else{
   			alert("Please enter an valid input");
   			return false;
   			$( "#user_input_val" ).focus();
   		}
   	}
   });
   $(document).on("click", "#remove_todo", function(e){
   	var id = $(this).attr('name');
   	$.ajax({
   		 url  : '/todolist/todoajax.php',
   		 type : "POST",
   		 cache : false,
   		 data : {id:id,key:'remove'},
   		 success : function(data){
   			 var data_split = data.split("~~");
   			$('#list_frame').html(data_split[0]);
   			$('#itemcount').html(data_split[1]);
   		 }
   		});
   });
   $(document).on("click", ".checkbox_todo", function(e){
   	var id = $('.checkbox_todo:checked').val();
   	$.ajax({
   		 url  : '/todolist/todoajax.php',
   		 type : "POST",
   		 cache : false,
   		 data : {id:id,key:'checked'},
   		 success : function(data){
   			 var data_split = data.split("~~");
   			$('#list_frame').html(data_split[0]);
   			$('#itemcount').html(data_split[1]);
   		 }
   	});
   	
   });
</script>