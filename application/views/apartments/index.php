<table class="apartments">
    <tr>
        <td>Appartement</td>
        <td>Ort</td>
        <td>Schlafplätze</td>
        <td>Preis 1</td>
        <td>Preis 2</td>
        <td>Preis 3</td>
        <td></td>
    </tr>
    <?php foreach($apartments as $apartment) : ?>
        <tr>
            <td><?= $apartment['address']; ?></td>
            <td><?= $apartment['city']; ?></td>
            <td><?= $apartment['beds']; ?></td>
            <td><?= $apartment['price1']; ?></td>
            <td><?= $apartment['price2']; ?></td>
            <td><?= $apartment['price3']; ?></td>
            <td>
                <a href="/apartments/edit/<?= $apartment['id']; ?>">Bearbeiten</a>
                /
                <a class="delete" href="javascript:void(0)" data-attr-apartment_id="<?= $apartment['id']; ?>">Löschen</a>
            </td>
        </tr>
    <?php endforeach; ?>
</table>