<table class="apartments">
    <tr>
        <th>Appartement</th>
        <th>Ort</th>
        <th>Schlafplätze</th>
        <th>Preis 1</th>
        <th>Preis 2</th>
        <th>Preis 3</th>
        <th></th>
        <th></th>
    </tr>
    <?php foreach($apartments as $apartment) : ?>
        <tr>
            <td><?= $apartment['address']; ?></td>
            <td><?= $apartment['city']; ?></td>
            <td class="text-center"><?= $apartment['beds']; ?></td>
            <td class="text-right"><?= $apartment['price1']; ?></td>
            <td class="text-right"><?= $apartment['price2']; ?></td>
            <td class="text-right"><?= $apartment['price3']; ?></td>
            <td>
                <a class="edit" title="Bearbeiten" href="/apartments/edit/<?= $apartment['id']; ?>"><i class="fa fa-edit" aria-hidden="true"></i></a>
            </td>
            <td>
                <a class="delete" title="Löschen" href="javascript:void(0)" data-attr-apartment_id="<?= $apartment['id']; ?>"><i class="fa fa-window-close-o" aria-hidden="true"></i></a>
            </td>
        </tr>
    <?php endforeach; ?>
</table>