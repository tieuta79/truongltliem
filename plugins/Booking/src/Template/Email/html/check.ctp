<h2><?= __d('ittvn', 'Infomation people checking'); ?></h2>
<p><strong><?= __d('ittvn', 'First name'); ?></strong>: <?= $booking['first_name']; ?></p>
<p><strong><?= __d('ittvn', 'Last name'); ?></strong>: <?= $booking['last_name']; ?></p>
<p><strong><?= __d('ittvn', 'Email'); ?></strong>: <?= $booking['email']; ?></p>
<p><strong><?= __d('ittvn', 'Phone'); ?></strong>: <?= $booking['phone']; ?></p>

<h2><?= __d('ittvn', 'Infomation room type'); ?></h2>
<p><strong><?= __d('ittvn', 'Room type'); ?></strong>: <?= $content['name']; ?></p>
<p><strong><?= __d('ittvn', 'Price'); ?></strong>: <?= $this->Layout->formatCurrency($content->Price_meta); ?></p>
<p><strong><?= __d('ittvn', 'Check in'); ?></strong>: <?= $booking['checkin']; ?></p>
<p><strong><?= __d('ittvn', 'Check out'); ?></strong>: <?= $booking['checkout']; ?></p>
<p><strong><?= __d('ittvn', 'Adults'); ?></strong>: <?= $booking['adults']; ?></p>
<p><strong><?= __d('ittvn', 'Children'); ?></strong>: <?= $booking['children']; ?></p>