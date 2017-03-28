<table class="fairs">
    <tr>
        <td>Name</td>
        <td>Ort</td>
        <td>Datum von</td>
        <td>Datum bis</td>
        <td>Preis</td>
        <td></td>
    </tr>
    <?php foreach($fairs as $fair) : ?>
        <tr>
            <td><?= $fair['name'] ?></td>
            <td><?= $fair['city'] ?></td>
            <td><?= $fair['start'] ?></td>
            <td><?= $fair['end'] ?></td>
            <td><?= $fair['price'] . " €" ?></td>
            <td>
                <a href="/fairs/edit/<?= $fair['id']; ?>">Bearbeiten</a>
                /
                <a class="delete" href="javascript:void(0)" data-attr-fair_id="<?= $fair['id']; ?>">Löschen</a>
            </td>
        </tr>
    <?php endforeach; ?>
</table>