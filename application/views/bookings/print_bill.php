<div id="print">
	<div style="background-color: #0000FF;width: 100%">
		PRINTER
	</div>
	<table>
		<tr>
			<td style="border: 1px solid ">1</td>
			<td style="border: 1px solid ">2</td>
			<td style="border: 1px solid ">3</td>
		</tr>
	</table>
</div>
<a id="printer" title="Print">Print</a>
<script>
	$(document).on('click', '#printer', function() {
		$(this).hide();
		$('.menu, #menu-trigger-label, .search, h1').hide();
		window.print();
		$(this).show();
		$('.menu, #menu-trigger-label, .search, h1').show();
	});
</script>
