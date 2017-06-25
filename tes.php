<?php include 'isi/header.php';?>
<?php
	if (isset($_POST['tes'])) {
		echo 'bangsat';
	}
?>
    
<input type="radio" name="muncul" value="value" id="value_radio" onclick="document.getElementById('value_input').focus()" required>
    
<label for="value_input">&euro;</label>
<input type="text" name="price_value" id="value_input" pattern="\d+(,\d{1,2})?" 
	onclick="document.getElementById('value_radio').checked=true">
 
<input type="radio" name="muncul" id="free" value="free">
<label for="free">Free</label>
 
 <div id="send_to">
    <input type="radio" id="send_poll" name="people" value="all" checked="checked">all the attendees</br>      
    <input type="radio" id="send_poll" name="people" value="one" >only one attendee<br/>
    <div id="send_to_one">
      <label>Write the attendee's name: </label><input type="text" id="attendeename"><br/><br/>
    </div>
    <input type="radio" id="send_poll" name="people" value="group">a group of attendees</br>              
  </div>
  <script type="text/javascript">
  	$(document).ready(function() {
    $("#send_to_one").hide();
    $("input:radio[name='people']").change(function(){  
         if(this.checked){
            if(this.value =='one'){
              $("#send_to_one").show()
            }else{
              $("#send_to_one").hide();
            }
         } 
    });
});
  </script>

<?php include 'isi/footer.php';?>