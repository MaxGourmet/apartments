<input type="checkbox" id="menu-trigger">
<label for="menu-trigger" id="menu-trigger-label">
    <i class="fa fa-bars" aria-hidden="true"></i>
    <i class="fa fa-window-close" aria-hidden="true"></i>
</label>
<div class="menu">
    <?php if (in_array(user('role'), ['admin', 'viewer'])) : ?>
        <div>
            <a href="<?= site_url(''); ?>"><?= $menuLang['calendar'] ?></a>
        </div>
		<?php if (in_array(user('role'), ['admin'])) : ?>
			<div>
				<a href="<?= site_url('bookings'); ?>"><?= $menuLang['debtors'] ?></a>
			</div>
			<div>
				<a href="<?= site_url('bookings/create'); ?>"><?= $menuLang['new_booking'] ?></a>
			</div>
		<?php endif; ?>
        <div>
            <a href="<?= site_url('apartments'); ?>"><?= $menuLang['apartments'] ?></a>
        </div>
		<?php if (in_array(user('role'), ['admin'])) : ?>
			<div>
				<a href="<?= site_url('apartments/create'); ?>"><?= $menuLang['new_apartment'] ?></a>
			</div>
		<?php endif; ?>
        <div>
            <a href="<?= site_url('fairs'); ?>"><?= $menuLang['fairs'] ?></a>
        </div>
		<?php if (in_array(user('role'), ['admin'])) : ?>
			<div>
				<a href="<?= site_url('fairs/create'); ?>"><?= $menuLang['new_fair'] ?></a>
			</div>
			<div>
				<a href="<?= site_url('bookings/reminder'); ?>"><?= $menuLang['reminder'] ?></a>
			</div>
			<div>
				<a href="<?= site_url('customers'); ?>"><?= $menuLang['customers'] ?></a>
			</div>
			<div>
				<a href="<?= site_url('customers/create'); ?>"><?= $menuLang['new_customer'] ?></a>
			</div>
			<div>
				<a href="<?= site_url('services'); ?>">Zusatzleistungen</a>
			</div>
			<div>
				<a href="<?= site_url('services/create'); ?>">Neue Zusatzleistungen</a>
			</div>
		<?php endif; ?>
    <?php endif; ?>
    <div class="logout">
        <a href="/auth/logout"><i class="fa fa-toggle-left" aria-hidden="true"></i> Ausloggen</a>
    </div>
</div>
