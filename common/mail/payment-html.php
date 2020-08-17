<p>Buenos d&iacute;as / Buenas tardes</p>
<p>Hemos recibido un pago de tu reservación <?= $booking->reference; ?></p>

<?php foreach($booking->payments as $payment): ?>
    <div>
        <h4><i class="fas fa-credit-card d-inline mr-3"></i>Pago con tarjeta de crédito / débito.</h4>
        <p><?= $payment->getFormatted('details') ?></p>
        <p><b><?= $payment->getFormatted('amount'); ?></b></p>
    </div>
<?php endforeach;?>

<p>Es un gusto confirmar los servicios de transportaci&oacute;n de acuerdo con lo siguiente:&nbsp;</p>
<p><strong><?= $booking->from_address; ?> &ndash; <?= $booking->to_address; ?></strong></p>
<p>Nombre: <?= $booking->client->profile->name; ?></p>
<p>Fecha de llegada: <?= date('d/m/Y', strtotime($booking->pickup)); ?></p>
<p>Aerol&iacute;nea y No. de Vuelo:</p>
<p>Hora de llegada: <?= date('H:i', strtotime($booking->pickup)); ?> hrs.</p>
<p>Pasajeros: <?= $booking->passanger_name; ?></p>
<?php $i = 1;foreach($booking->vehicles as $vehicle): ?>
<p>Veh&iacute;culo <?= $i; ?>: <?= $vehicle->vehicleType->name; ?></p>
<?php $i++; ; endforeach; ?>