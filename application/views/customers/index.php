<?php $isViewer = user('role') == 'viewer'; ?>
<table class="apartments">
	<thead>
	<tr>
		<th class="sort" data-element="name" data-order="desc" style="cursor: pointer">Customer</th>
		<th>Is company?</th>
		<th>Company name</th>
		<?php if (!$isViewer) : ?>
			<th></th>
		<?php endif; ?>
		<th></th>
	</tr>
	</thead>
	<?php $now = time(); ?>
	<tbody>
    <?php foreach($customers as $customer) : ?>
        <tr class="apartment-entity">
            <td data-sort="name"><?= $customer['users_name']; ?></td>
            <td class="text-center">
				<input type="checkbox" name="c" value="<?= $customer['is_company']; ?>" disabled />
			</td>
            <td class="text-center"><?= $customer['is_company'] ? $customer['company_name'] : ''; ?></td>
            <td>
                <a class="edit" title="Bearbeiten" href="/customers/edit/<?= $customer['id']; ?>"><i class="fa fa-edit" aria-hidden="true"></i></a>
            </td>
			<?php if (!$isViewer) : ?>
				<td>
					<a class="delete" title="Löschen" href="javascript:void(0)" data-attr-apartment_id="<?= $customer['id']; ?>"><i class="fa fa-window-close-o" aria-hidden="true"></i></a>
				</td>
			<?php endif; ?>
        </tr>
    <?php endforeach; ?>
	</tbody>
</table>
