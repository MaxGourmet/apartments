<?php $isViewer = user('role') == 'viewer'; ?>
<table class="apartments">
	<thead>
	<tr>
		<th class="sort" data-element="name" data-order="desc" style="cursor: pointer">Appartement</th>
		<th>Ort</th>
		<th>Schlafplätze</th>
		<th>Last clean</th>
		<th class="sort" data-element="days" data-order="asc" style="cursor: pointer">Days after</th>
		<th class="sort" data-element="days" data-order="asc" style="cursor: pointer">Clean+3</th>
		<th class="sort" data-element="days" data-order="asc" style="cursor: pointer">Clean+7</th>
		<th class="sort" data-element="days" data-order="asc" style="cursor: pointer">Clean+14</th>
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
	<?php $lcd = $apartment['last_clean_date']; ?>
        <tr class="apartment-entity">
            <td data-sort="name"><?= $apartment['address']; ?></td>
            <td><?= $apartment['city']; ?></td>
            <td class="text-center"><?= $apartment['beds']; ?></td>
            <td class="text-right"><?= date('Y-m-d', strtotime($lcd)); ?></td>
            <td data-sort="days" class="text-right"><?= $lcd ? floor(($now - strtotime($lcd)) / (60 * 60 * 24)) : ''; ?></td>
            <td data-sort="days" class="text-right"><?= $lcd ? date('Y-m-d', strtotime($lcd . " + 3 days")) : ''; ?></td>
            <td data-sort="days" class="text-right"><?= $lcd ? date('Y-m-d', strtotime($lcd . " + 7 days")) : ''; ?></td>
            <td data-sort="days" class="text-right"><?= $lcd ? date('Y-m-d', strtotime($lcd . " + 14 days")) : ''; ?></td>
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
