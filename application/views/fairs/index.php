<?php $isViewer = user('role') == 'viewer'; ?>
<table class="fairs">
    <tr>
        <th>Name</th>
        <th>Ort</th>
        <th>Datum von</th>
        <th>Datum bis</th>
        <th>Preis</th>
        <th></th>
		<?php if (!$isViewer) : ?>
			<th></th>
		<?php endif; ?>
    </tr>
    <?php foreach($fairs as $fair) : ?>
        <tr>
            <td><?= $fair['name'] ?></td>
            <td><?= $fair['city'] ?></td>
			<td class="text-right"><?= date('d.m.Y', strtotime($fair['start'])) ?></td>
            <td class="text-right"><?= date('d.m.Y', strtotime($fair['end'])) ?></td>
            <td class="text-right"><?= $fair['price'] . " €" ?></td>
            <td>
                <a class="edit" href="/fairs/edit/<?= $fair['id']; ?>"><i class="fa fa-edit" aria-hidden="true"></i></a>
            </td>
			<?php if (!$isViewer) : ?>
				<td>
					<a class="delete" href="javascript:void(0)" data-attr-fair_id="<?= $fair['id']; ?>"><i class="fa fa-window-close-o" aria-hidden="true"></i></a>
				</td>
			<?php endif; ?>
        </tr>
    <?php endforeach; ?>
</table>
