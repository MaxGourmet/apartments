<div id="print">
	<div style="">
		Картинка
	</div>
	<div style="text-align: right">
		<div style="font-weight: bold"><pre><?= $billConfigs['contacts']; ?></pre></div>
		<br />
		<div style="font-weight: bold;font-size: 0.55rem;"><pre><?= $billConfigs['phone']; ?></pre></div>
		<div style="font-weight: bold;font-size: 0.55rem;"><a href="mailto:<?= $billConfigs['email']; ?>"><?= $billConfigs['email']; ?></a></div>
		<br />
		<div style="font-size: 0.45rem;">
			Finanzamt <?= $billConfigs['tax_office']; ?>
		</div>
		<br />
		<div style="font-size: 0.45rem;"><pre><?= $billConfigs['tax_numbers']; ?></pre></div>
		<div>
			Düsseldorf, <?= date('d.m.Y'); ?>
		</div>
	</div>
	<h1>Rechnung: <?= $booking['id'] . "-" . date('dmY'); ?></h1>
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
