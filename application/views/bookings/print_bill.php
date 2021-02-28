<div id="print">
	<div style="background-color: #0000FF;width: 100%">
		PRINTER
	</div>
</div>
<a id="printer" title="Print">Print</a>
<script>
	$(document).on('click', '#printer', function() {
		$(this).hide();
		window.print();
	});
</script>
