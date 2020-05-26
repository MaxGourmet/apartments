<?php $isViewer = user('role') == 'viewer'; ?>
<table class="apartments">
	<thead>
	<tr>
		<th class="sort" data-element="name" data-order="desc" style="cursor: pointer">Appartement</th>
		<th>Ort</th>
		<th>Schlafplätze</th>
		<th>Preis 1</th>
		<th>Preis 2</th>
		<th>Preis 3</th>
		<th>Last clean date</th>
		<th class="sort" data-element="days" data-order="asc" style="cursor: pointer">Days after clean</th>
		<?php if (!$isViewer) : ?>
			<th></th>
			<th></th>
		<?php endif; ?>
		<th></th>
	</tr>
	</thead>
	<?php $now = time(); ?>
	<tbody>
    <?php foreach($apartments as $apartment) : ?>
        <tr class="apartment-entity">
            <td data-sort="name"><?= $apartment['address']; ?></td>
            <td><?= $apartment['city']; ?></td>
            <td class="text-center"><?= $apartment['beds']; ?></td>
            <td class="text-right"><?= $apartment['price1']; ?></td>
            <td class="text-right"><?= $apartment['price2']; ?></td>
            <td class="text-right"><?= $apartment['price3']; ?></td>
            <td class="text-right"><?= $apartment['last_clean_date']; ?></td>
            <td data-sort="days" class="text-right"><?= $apartment['last_clean_date'] ? floor(($now - strtotime($apartment['last_clean_date'])) / (60 * 60 * 24)) : ''; ?></td>
			<?php if (!$isViewer) : ?>
				<td>
					<a title="Copy link" href="/export/calendar/<?= $apartment['id']; ?>">Export</a>
				</td>
			<?php endif; ?>
            <td>
                <a class="edit" title="Bearbeiten" href="/apartments/edit/<?= $apartment['id']; ?>"><i class="fa fa-edit" aria-hidden="true"></i></a>
            </td>
			<?php if (!$isViewer) : ?>
				<td>
					<a class="delete" title="Löschen" href="javascript:void(0)" data-attr-apartment_id="<?= $apartment['id']; ?>"><i class="fa fa-window-close-o" aria-hidden="true"></i></a>
				</td>
			<?php endif; ?>
        </tr>
    <?php endforeach; ?>
	</tbody>
</table>
