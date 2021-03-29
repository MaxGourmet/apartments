<?php $isViewer = user('role') == 'viewer'; ?>
<table class="services">
    <tr>
        <th>Name</th>
        <th>Beschreibung</th>
        <th>Preis</th>
        <th>TVA</th>
        <th></th>
		<?php if (!$isViewer) : ?>
			<th></th>
		<?php endif; ?>
    </tr>
    <?php foreach($services as $service) : ?>
        <tr>
            <td><?= $service['name'] ?></td>
            <td><?= $service['description'] ?></td>
            <td class="text-right"><?= $service['price'] . " €" ?></td>
			<td><?= $vatRates[$service['vat_rate']] ?> %</td>
            <td>
                <a class="edit" href="/services/edit/<?= $service['id']; ?>"><i class="fa fa-edit" aria-hidden="true"></i></a>
            </td>
			<?php if (!$isViewer) : ?>
				<td>
					<a class="delete" href="javascript:void(0)" data-attr-service_id="<?= $service['id']; ?>"><i class="fa fa-window-close-o" aria-hidden="true"></i></a>
				</td>
			<?php endif; ?>
        </tr>
    <?php endforeach; ?>
</table>
