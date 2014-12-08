<script type="text/javascript" class="init">
	$(document).ready(function() {

	    $(function () {
		    $('.check').on('click', function () {
		        $('.selectCheckBox').each(function(){ this.checked = true; });
		    });
		});

		$(function () {
		    $('.uncheck').on('click', function () {
		        $('.selectCheckBox').each(function(){ this.checked = false; });
		    });
		});

	});
</script>