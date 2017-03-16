<table class="apartments">
    <tr>
        <td></td>
        <?php for($i = 0; $i < $monthDays; $i++) : ?>
            <td><?= $i+1; ?></td>
        <?php endfor; ?>
    </tr>
    <?php foreach($apartments as $apartment) : ?>
        <tr>
            <td><?= $apartment['address']; ?></td>
            <?php for($i = 0; $i < $monthDays; $i++) : ?>
                <td class="free"></td>
            <?php endfor; ?>
        </tr>
    <?php endforeach; ?>
</table>