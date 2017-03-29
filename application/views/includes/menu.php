<input type="checkbox" id="menu-trigger">
<label for="menu-trigger" id="menu-trigger-label">
    <i class="fa fa-bars" aria-hidden="true"></i>
    <i class="fa fa-window-close" aria-hidden="true"></i>
</label>
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
    <?php endif; ?>
    <div class="logout">
        <a href="/auth/logout"><i class="fa fa-toggle-left" aria-hidden="true"></i> Ausloggen</a>
    </div>
</div>