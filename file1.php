<html>

</head>

<body>
  <input type="text" id="zip_code" name="zip_code" />

   <input type="text" id="city" name="city" />
   <input type="button" id="submit" value="submit" />
   <div id='div'></div>
</body>
<script src='libs/js/jQuery/jquery-3.4.1.js'></script>
 <script type="text/javascript">
   $(document).ready(function(){
       $("#submit").click(function(){
         var zip = $('#zip_code').val();
         var getUrl = window.location;
         $.ajax({
           url: getUrl+'?zip='+zip,
           type: 'GET',
           success: function(data){
             alert(data);
           }
         });

   });
});
</script>
 </html>
