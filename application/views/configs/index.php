<table class="configs">
    <tr>
        <td>Alias</td>
        <td>Name</td>
        <td>Value</td>
        <td>Actions</td>
    </tr>
    <?php foreach($configs as $config) : ?>
        <tr>
            <td><?= $config['alias'] ?></td>
            <td><?= $config['name'] ?></td>
            <td><?= $config['value'] ?></td>
            <td>
                <a href="/configs/edit/<?= $config['id'] ?>">Edit</a>
            </td>
        </tr>
    <?php endforeach; ?>
</table>