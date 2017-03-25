<table class="fairs">
    <tr>
        <td>Name</td>
        <td>City</td>
        <td>Start</td>
        <td>End</td>
        <td>Price</td>
        <td>Actions</td>
    </tr>
    <?php foreach($fairs as $fair) : ?>
        <tr>
            <td><?= $fair['name'] ?></td>
            <td><?= $fair['city'] ?></td>
            <td><?= $fair['start'] ?></td>
            <td><?= $fair['end'] ?></td>
            <td><?= $fair['price'] . " €" ?></td>
            <td>
                <a href="/fairs/edit/<?= $fair['id']; ?>">Edit</a>
                /
                <a class="delete" href="javascript:void(0)" data-attr-fair_id="<?= $fair['id']; ?>">Delete</a>
            </td>
        </tr>
    <?php endforeach; ?>
</table>