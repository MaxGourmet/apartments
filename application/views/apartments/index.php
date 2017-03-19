<table class="apartments">
    <tr>
        <td>Apartment</td>
        <td>City</td>
        <td>Beds</td>
        <td>Price 1</td>
        <td>Price 2</td>
        <td>Price 3</td>
        <td>Actions</td>
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
                <a href="/apartments/edit/<?= $apartment['id']; ?>">Edit</a>
                /
                <a class="delete" href="javascript:void(0)" data-attr-apartment_id="<?= $apartment['id']; ?>">Delete</a>
            </td>
        </tr>
    <?php endforeach; ?>
</table>