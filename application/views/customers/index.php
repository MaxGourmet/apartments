<style>
	.customers [name="c"] {
		display: inline-block;
		margin-right: 15px;
		margin-left: 15px;
		-webkit-appearance: checkbox;
		-moz-appearance: checkbox;
		appearance: checkbox;
	}
</style>
<?php $isViewer = user('role') == 'viewer'; ?>
<table class="customers">
	<thead>
	<tr>
		<th class="sort" data-element="name" data-order="desc" style="cursor: pointer">Kunden</th>
		<th>Geschäftskunde</th>
		<th>Firmenname</th>
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
            <td data-sort="name"><?= $customer['first_name'] . " " . $customer['last_name'] ?></td>
            <td class="text-center">
				<input type="checkbox" name="c" value="0" <?= $customer['is_company'] ? "checked" : ""; ?> disabled />
			</td>
            <td class="text-center"><?= $customer['is_company'] ? $customer['company_name'] : ''; ?></td>
            <td>
                <a class="edit" title="Bearbeiten" href="/customers/edit/<?= $customer['id']; ?>"><i class="fa fa-edit" aria-hidden="true"></i></a>
            </td>
			<?php if (!$isViewer) : ?>
				<td>
					<a class="delete" title="Löschen" href="javascript:void(0)" data-attr-customer_id="<?= $customer['id']; ?>"><i class="fa fa-window-close-o" aria-hidden="true"></i></a>
				</td>
			<?php endif; ?>
        </tr>
    <?php endforeach; ?>
	</tbody>
</table>
