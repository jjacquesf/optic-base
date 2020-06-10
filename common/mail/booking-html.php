<p>Buenos d&iacute;as / Buenas tardes</p>
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
<p></p>
<!-- <p><strong>Destino &ndash; Aeropuerto</strong></p>
<p>Fecha de Salida:</p>;
<p>Aerol&iacute;nea y No. de Vuelo:</p>
<p>Hora de Salida:</p>
<p>Hora de Pick up:</p>
<p>Pasajeros:</p>
<p>Veh&iacute;culo:&nbsp;</p> -->
<p>&nbsp;</p>
<p><strong><u>Instrucciones para localizarnos en Terminal 1:</u></strong></p>
<p>Una vez que tenga su equipaje&nbsp;favor de salir por las puertas corredizas a mano derecha siguiendo los letreros que dice&nbsp;<strong><u>LLEGADAS DE GRUPOS</u></strong>, por cuestiones de seguridad los operadores no pueden ingresar a la terminal, pero estar&aacute; a fuera con un letrero de OPTIC (favor de ver adjunto). Ellos estar&aacute;n usando uniforme camisa color gris &amp; pantal&oacute;n negro para su f&aacute;cil reconocimiento.&nbsp;</p>
<p>El personal de tiempo compartido de diferentes compa&ntilde;&iacute;as intentar&aacute; acercarse y distraer su atenci&oacute;n, les tomar&aacute; mucho tiempo simplemente ev&iacute;telos salga de la terminal como dice en las instrucciones.</p>
<p><strong><u>&nbsp;</u></strong></p>
<p><strong><u>*La transportaci&oacute;n debe ser pagada en su llegada. El total es de $000.00 usd con tarjeta de cr&eacute;dito / d&eacute;bito (Visa o MasterCard). La gratificiaci&oacute;n no est&aacute; incluida en el precio*</u></strong></p>
<p></p>
<p><strong><u>Instrucciones para localizarnos en Terminal 1:</u></strong></p>
<p>De acuerdo con las pol&iacute;ticas del aeropuerto, las locaciones de las transportaciones y anfitriones ha cambiado. A continuaci&oacute;n, encontrar&aacute; la informaci&oacute;n actualizada para encontrarnos:&nbsp;</p>
<ol>
<li>Despu&eacute;s de pasar aduana, por favor evite a los promotores de tiempo compartido. Cuando salga de la terminal encontrar&aacute; la l&iacute;nea donde las transportaciones privadas sol&iacute;an estar, ahora esa locaci&oacute;n pertenece a los taxistas.</li>
<li>Por favor evite a los taxistas y siga derecho, ver&aacute; en seguida algunas sombras / carpas alineadas.</li>
<li>Dichas sombras / carpas est&aacute;n enumeradas, favor de buscar las n&uacute;mero <strong>2 o 3</strong>.</li>
<li>Favor de encontrar a nuestra anfitriona, que estar&aacute; sosteniendo un cartel con el logotipo de OPTIC.<strong> (Ver adjunto)</strong>.</li>
</ol>
<p>Es de suma importancia informarle que, debido a las autoridades del aeropuerto, no todas las compa&ntilde;&iacute;as de transportaci&oacute;n privada tienen permitido estacionarse cerca de la secci&oacute;n de bienvenida. Por lo tanto, nuestras anfitrionas los acompa&ntilde;ar&aacute;n al lugar donde su conductor los estar&aacute; esperando para llegar a su veh&iacute;culo.</p>
<p>&nbsp;</p>
<p><strong><u>COVID-19 Medidas de seguridad Optic:</u></strong></p>
<p></p>
<p>*Nuestros veh&iacute;culos se desinfectan para cada traslado (puertas, manijas, asientos)</p>
<p>*Nuestro equipo (conductor y anfitriona) utilizar&aacute; equipo de protecci&oacute;n.</p>
<p>*Durante su traslado, tendremos disponible gel antibacterial y toallas desinfectantes.</p>
<p>*Las bebidas que se ofrecen est&aacute;n limpias y desinfectadas.</p>
<p>Si hay alg&uacute;n cambio en lo anterior o si tiene alguna pregunta, no dude en hac&eacute;rmelo saber.</p>