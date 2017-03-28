<div class="menu">
    <?php if (user('role') == 'admin') : ?>
        <div>
            <a href="<?= site_url(''); ?>"><?= $menuLang['calendar'] ?></a>
        </div>
        <div>
            <a href="<?= site_url('bookings'); ?>"><?= $menuLang['debtors'] ?></a>
        </div>
        <div>
            <a href="<?= site_url('bookings/create'); ?>"><?= $menuLang['new_booking'] ?></a>
        </div>
        <div>
            <a href="<?= site_url('apartments'); ?>"><?= $menuLang['apartments'] ?></a>
        </div>
        <div>
            <a href="<?= site_url('apartments/create'); ?>"><?= $menuLang['new_apartment'] ?></a>
        </div>
        <div>
            <a href="<?= site_url('fairs'); ?>"><?= $menuLang['fairs'] ?></a>
        </div>
        <div>
            <a href="<?= site_url('fairs/create'); ?>"><?= $menuLang['new_fair'] ?></a>
        </div>
        <div>
            <a href="<?= site_url('bookings/reminder'); ?>"><?= $menuLang['reminder'] ?></a>
        </div>
        <div class="search">
            <input name="search" placeholder="Suchen" />
            <a href="javascript:void(0)" id="search">Suchen</a>
        </div>
    <?php endif; ?>
    <div class="logout">
        <a href="/auth/logout">Ausloggen</a>
    </div>
</div>