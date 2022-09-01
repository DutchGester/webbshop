<html>
<head>
<title>Search</title>
<script src='libs/js/jQuery/jquery-3.4.1.js'></script>
<script src='libs/js/bootstrap/bootstrap.bundleLAST.js'></script>
<link rel="stylesheet" href="libs/css/bootstrap/bootstrapLAST.css"/>
<style>
#show_search{
	width: 200px;
	height: 200px;
	border: 1px solid #ddd;
	display: none;
}
#show_search a{
	border-bottom: 1px solid #ddd;
	display: block;
	padding: 5px;
}
</style>
</head>
<body>
<script>
$(document).ready(function(e){
	$("#search").keyup(function(){
		this.value ? $("#show_search").show() : $("#show_search").hide();
		var text = $(this).val();
		$.ajax({
			type: 'GET',
			url: 'search.php',
			data: 'txt=' + text,
			success: function(data){
				$("#show_search").html(data);
			}
		});
	})
});

</script>
<input type="text" name="names" id="search" />
<div id="show_search"></div>
</body>
</html>
