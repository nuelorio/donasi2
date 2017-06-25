$(function() {
  $("#lain").on("click",function() {
    $(".lembagaLain").fadeToggle(this.checked);
  });
  $("#lain3").on("click",function() {
    $(".untukLain").fadeToggle(this.checked);
  });
});

$(document).ready(function() {
    $("#hilang").hide();
    $("input:radio[name='muncul']").change(function(){  
         if(this.checked){
            if(this.value == 'one'){
              $("#hilang").show()
            }else{
              $("#hilang").hide();
            }
         } 
    });
});



// $('#value_radio').change(function () {
//     if(this.checked) {
//         $('#value_input').prop('required', true);
//     } else {
//         $('#value_input').prop('required', false);
//     }
// });