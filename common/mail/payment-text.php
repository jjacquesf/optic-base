Buenos d&iacute;as / Buenas tardes
Hemos recibido un pago de tu reservación <?= $booking->reference; ?>

<?php foreach($booking->payments as $payment): ?>
    Pago con tarjeta de crédito / débito.
    <?= $payment->getFormatted('details') ?>
    <?= $payment->getFormatted('amount'); ?>
<?php endforeach;?>

Es un gusto confirmar los servicios de transportaci&oacute;n de acuerdo con lo siguiente:&nbsp;
<?= $booking->from_address; ?> &ndash; <?= $booking->to_address; ?>
Nombre: <?= $booking->client->profile->name; ?>
Fecha de llegada: <?= date('d/m/Y', strtotime($booking->pickup)); ?>
Aerol&iacute;nea y No. de Vuelo:
Hora de llegada: <?= date('H:i', strtotime($booking->pickup)); ?> hrs.
Pasajeros: <?= $booking->passanger_name; ?>
<?php $i = 1;foreach($booking->vehicles as $vehicle): ?>
Veh&iacute;culo <?= $i; ?>: <?= $vehicle->vehicleType->name; ?>
<?php $i++; ; endforeach; ?>