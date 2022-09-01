<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>

<style>

  #show_search{
  	width: 506px;
  	height: auto;
  	border: 2px solid black;
  	display: none;
    position: absolute;
z-index:1;
    }
  #show_search a{
  	border-bottom: 1px solid #ddd;
  	display: block;
    text-decoration: none;
    color:black;
    padding:10px;
    text-align: center;
    z-index:1;
    background:yellow;
  }
  #search {
    z-index:1;
  }

  #overlay {
    position: fixed;
    display: none;
    width: 100%;
    height: 100%;
    top: 0;
    left: 0;
    right: 0;
    bottom: 0;
    background-color: rgba(0,0,0,0.5);
    z-index: -1;
    cursor: default;
  }
  </style>
<div id="overlay"></div>
<form class="form-inline my-0"><div class="form-group has-search">
<span class="fa fa-search form-control-feedback"></span>
<input id='search' type="text" class="form-control input-more-width" placeholder="Search">
</div></form><div class="show_search" id="show_search"><a>LINK:aaaaaa</a><a>LINK:bbbbbbb</a><a>LINK:cccccccc</a></div>
<a><button style="margin-right:4px;font-weight:650;" type="button" class="btn btn-primary clickme">Checkout</button></a>
<script>

  $(document).ready(function(){
      $("a button").click(function(){
      $.ajax({
          url: 'file1.php',
          type: 'POST',
          //data: {'number' : 10}, //this is when you need send parameters to the call, uncomment to send it parameters
          dataType: 'json',
          success: function(result){
              alert(result);
              },
          error: function(){
              alert("Error");
              }
          });
      });
  });

  $("body").click(function(e) {
         if($(e.target).is('#search')){
             e.preventDefault();
             return;
         }
         // alert("woohoo!");
     });

  $("#search").keyup(function(){
$("#show_search").show();
  });

  $('#search').focus(function() {
  $("#overlay").show();
  $("#search").keyup(function(){
  	$("#overlay").show();
  $('#search').focusout(function() {
  $(".show_search").hide();
  $("#overlay").hide();
  		});
  	});
  });
  </script>
