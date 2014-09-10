<script type="text/javascript">
	$(document).ready(function () {
	$('#m-carousel').carousel()

	if (navigator.appName == 'Microsoft Internet Explorer')
    {
		$("select").focus(
			function () {
				$(this).css("border", "1px solid #CBCBCB");
			  }, 
			function () {
				$(this).css("border", "1px solid #090909");
			  }
			);	
		$("select").hover(
			function () {
				$(this).css("border", "1px solid #A4A4A4");
			  }, 
			function () {
				$(this).css("border", "1px solid #CBCBCB");
			  }
			);	
		$("select").hover.focus(
			function () {
				$(this).css("border", "1px solid #090909");
			  }, 
			function () {
				$(this).css("border", "1px solid #CBCBCB");
			  }
			);
	}
	});
</script>