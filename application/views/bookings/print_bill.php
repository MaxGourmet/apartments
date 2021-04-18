<div id="print">
	<div style="">
		<img src="/assets/img/appnrw-logo.svg" alt="Appartments NRW" />
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
	</div>
	<div style="text-align: left">
		<div style="font-weight: bold;"><pre><?= $billConfigs['tax_address']; ?></pre></div>
	</div>
	<div style="text-align: right">
		<div>
			Düsseldorf, <?= date('d.m.Y'); ?>
		</div>
	</div>
	<div>
		<div style="font-size: 1rem; font-weight: bold">
			Rechnung: <?= $booking['id'] . "-" . date('dmY'); ?>
		</div>
		<div style="font-weight: bold">
			Hiermit berechnen wir für unsere Leistungen:
		</div>
	</div>
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
