<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
<style>

</style>

<div id="num">0</div><br/>

<input type="button" id="plus" value="+(Add)">
<input type="button" id="min" value="-(Subtrat)">

<script>
$(document).ready(function(){
  $("#min").prop("disabled", true); // initially minus is disabled
    $("#plus").click(function () { // on click of + button
      $('#num').html(parseInt($('#num').html())+1);  // get div number, add 1 and paste again to the div(new number)
      if(parseInt($('#num').html())>0){ //if new value is greater than 0
        $("#min").prop("disabled", false); // enable - button
      }else{
        $("#min").prop("disabled", true); // otherwise remain disable
      }
  });

  $("#min").click(function () { // on click of - button
    $('#num').html(parseInt($('#num').html())-1); // get div number,substract 1 and again paste again to the div(new number)
      if(parseInt($('#num').html())>0){ // if the new number is >0
        $("#min").prop("disabled", false); // remain enable of - button
      }else{
        $("#min").prop("disabled", true); // otherwise disable - button
      }
  });
});
</script>
