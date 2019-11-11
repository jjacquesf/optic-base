<?php
use frontend\assets\ThemeAsset;

$assets = ThemeAsset::register($this);

?><div class="slider-pro" id="home-slider">
    <div class="sp-slides">
    <div class="sp-slide"><img class="sp-image" data-default="<?= $assets->baseUrl; ?>/img/slider1_optic.jpg" data-retina="<?= $assets->baseUrl; ?>/img/slider1_optic.jpg" src="<?= $assets->baseUrl; ?>/img/slider1_optic.jpg" style="width: 100%; height: auto; margin-left: 0px; margin-top: -70px;">
        <div class="sp-layer">
        <div class="title">
            <h2>
            Excedemos
            tus expectativas
            </h2>
            <p>
            Toda la mobilidad que necesitas
            en un sólo lugar
            </p>
        </div>
        </div>
    </div>
    <div class="sp-slide"><img class="sp-image" data-default="<?= $assets->baseUrl; ?>/img/slider2_optic.jpg" data-retina="<?= $assets->baseUrl; ?>/img/slider2_optic.jpg" src="<?= $assets->baseUrl; ?>/img/slider2_optic.jpg" style="width: 100%; height: auto; margin-left: 0px; margin-top: -70px;">
        <div class="sp-layer layer-two">
        <div class="title">
            <h2>Vive Los Cabos</h2><span class="slogan">Los Cabos Premium Service</span>
        </div>
        </div>
    </div>
    <div class="sp-slide"><img class="sp-image" data-default="<?= $assets->baseUrl; ?>/img/slider3_optic.jpg" data-retina="<?= $assets->baseUrl; ?>/img/slider3_optic.jpg" src="<?= $assets->baseUrl; ?>/img/slider3_optic.jpg" style="width: 100%; height: auto; margin-left: 0px; margin-top: -70px;">
        <!--.sp-layer
        .title
        img(src="<?= $assets->baseUrl; ?>/img/LOGO_3_OPTIC.png", alt="Optic").img-responsive
        span.slogan Los Cabos Premium Service
        -->
    </div>
    </div>
</div>
<div class="Home">
    <div class="container-fluid">
    <div class="row">
        <div class="col-sm-12 my-5">
        <h2 data-aos="fade-up" data-aos-easing="ease-in-out">RESERVA EN LÍNEA</h2>
        </div>
    </div>
    <div class="row">
        <div class="col-md-4 col-lg-4">
        <div class="instructions" data-aos="fade-right" data-aos-duration="4000" data-aos-delay="200">
            <div class="item"><img src="<?= $assets->baseUrl; ?>/img/icon_11_optic.jpg" alt="Optic">
            <h3>Programa</h3>
            <p>Revisa la disponibilidad y las tarifas</p>
            </div>
            <div class="item"><img src="<?= $assets->baseUrl; ?>/img/icon_10_optic.jpg" alt="Optic">
            <h3>Elige</h3>
            <p>Busca el vehículo ideal para tus necesidades</p>
            </div>
            <div class="item"><img src="<?= $assets->baseUrl; ?>/img/icon_9_optic.jpg" alt="Optic">
            <h3>Selecciona</h3>
            <p>Escoge el método de pago y <span>reserva</span></p>
            </div>
        </div>
        </div>
        <div class="col-md-8 col-lg-8">
            <?= $this->render('_booking_form'); ?>
        </div>
    </div>
    <div class="row">
        <div class="col-sm-12 section-default">
        <h2 data-aos="fade-up" data-aos-easing="ease-in-out">NOSOTROS</h2>
        <h3 data-aos="fade-in" delay="500">Ofrecemos el mejor servicio privado de lujo de transportación.</h3>
        <p data-aos="fade-in" delay="500">
            Desde cualquier ubicación en Cabo San Lucas, San José del Cabo o los alrededores,
            todos los hoteles del corredor turístico y el aeropuerto internacional de Los Cabos.
            Contamos con personal bilingüe altamente capacitado en resolver todas la necesidades de transporte.
        </p><span data-aos="fade-in" delay="500">Unidades último modelo</span>
        </div>
    </div>
    <div class="row services parallax">
        <div class="col-sm-12 section-default">
        <h2 data-aos="fade-up" data-aos-easing="ease-in-out">SERVICIOS</h2>
        <h3 data-aos="fade-in" delay="500">Nuestro servicio ofrece transporte privado, exclusivo, seguro y confiable.</h3>
        <p data-aos="fade-in" delay="500">
            Nuestro personal de operaciones le apoya en todos los traslados para realizar
            actividades fuera del hotel.
        </p><span data-aos="fade-in" delay="500">Su satisfacción y seguridad es nuestra máxima prioridad.</span>
        </div>
    </div>
    <div class="row">
        <div class="col-sm-12">
        <h2 class="mt-5" data-aos="fade-up" data-aos-easing="ease-in-out">OFRECEMOS</h2>
        <div class="offers">
            <div class="item" data-aos="fade-in" delay="800" data-aos-duration="1000"><img class="img-responsive" src="<?= $assets->baseUrl; ?>/img/icon_1_optic.jpg" alt="Optic"><span>Unidades Privadas</span></div>
            <div class="item" data-aos="fade-in" delay="800" data-aos-duration="1000"><img class="img-responsive" src="<?= $assets->baseUrl; ?>/img/icon_2_optic.jpg" alt="Optic"><span>Chofere Bilingües y Certificados</span></div>
            <div class="item" data-aos="fade-in" delay="800" data-aos-duration="1000"><img class="img-responsive" src="<?= $assets->baseUrl; ?>/img/icon_3_optic.jpg" alt="Optic"><span>Amenidades de cortesía</span></div>
            <div class="item" data-aos="fade-in" delay="800" data-aos-duration="1000"><img class="img-responsive" src="<?= $assets->baseUrl; ?>/img/icon_4_optic.jpg" alt="Optic"><span>Seguro</span></div>
            <div class="item" data-aos="fade-in" delay="800" data-aos-duration="1000"><img class="img-responsive" src="<?= $assets->baseUrl; ?>/img/icon_5_optic.jpg" alt="Optic"><span>Wi Fi</span></div>
            <div class="item" data-aos="fade-in" delay="800" data-aos-duration="1000"><img class="img-responsive" src="<?= $assets->baseUrl; ?>/img/icon_6_optic.jpg" alt="Optic"><span>Cuotas de Autopista</span></div>
            <div class="item" data-aos="fade-in" delay="800" data-aos-duration="1000"><img class="img-responsive" src="<?= $assets->baseUrl; ?>/img/icon_7_optic.jpg" alt="Optic"><span>Manejo de su equipaje</span></div>
            <div class="item" data-aos="fade-in" delay="800" data-aos-duration="1000"><img class="img-responsive" src="<?= $assets->baseUrl; ?>/img/icon_8_optic.jpg" alt="Optic"><span>Rastreo de Vuelos
                <p>Sin Cargo Extra</p></span></div>
        </div>
        </div>
    </div>
    <div class="row">
        <div class="col-sm-12 px-0">
        <div class="cta-advantage">
            <div class="item" data-aos="fade-down" data-aos-duration="1000">
            <h2>
                TARIFAS
                TODO INCLUÍDO
            </h2>
            </div>
            <div class="item" data-aos="fade-down" data-aos-duration="1000">
            <h2>
                CONDUCTORES
                PROFESIONALES
            </h2>
            </div>
            <div class="item" data-aos="fade-down" data-aos-duration="1000">
            <h2>
                SIEMPRE
                A TIEMPO
            </h2>
            </div>
        </div>
        </div>
    </div>
    <div class="row parallax our-vehicles">
        <div class="col-sm-12 section-default transparency">
        <div class="content">
            <h2 data-aos="fade-up" data-aos-easing="ease-in-out">NUESTROS VEHÍCULOS</h2>
            <h3>Contamos con una variedad de vehículos, últimos modelos, conductores profesionales.</h3>
            <p>
            Servicio de transportación en Los Cabos, San José y sus alrededores,
            todos los hoteles del corredor turístico, Aeropuerto internacional de Los Cabos.
            </p><span>Tu traslado será una experiencia de alto nivel.</span>
        </div>
        </div>
    </div>
    <div class="row select-car">
        <div class="col-sm-12 px-0">
        <ul class="list-inline mb-0 models">
            <li class="active"><a href="#" onclick="showModel(this.id)" id="VCLASS">V CLASS</a></li>
            <li><a href="#" onclick="showModel(this.id)" id="ESCALADE">ESCALADE</a></li>
            <li><a href="#" onclick="showModel(this.id)" id="GL">GL 500</a></li>
            <li><a href="#" onclick="showModel(this.id)" id="SUBURBAN">SUBURBAN</a></li>
            <li><a href="#" onclick="showModel(this.id)" id="SPRINTER">SPRINTER</a></li>
            <li><a href="#" onclick="showModel(this.id)" id="MODEL">MODEL X</a></li>
        </ul>
        <div class="car-type vclass">
            <div class="main-img" data-aos="fade-up" data-aos-easing="ease-in-out"><img class="img-responsive" src="<?= $assets->baseUrl; ?>/img/banner_cars_optic_4.jpg" alt=""><a class="btn btn-primary reserve" href="#">RESERVAR</a></div>
            <ul class="list-inline mb-0">
            <li data-aos="fade-in" delay="800" data-aos-duration="1000"><a class="thumbnail one" href="#"></a></li>
            <li data-aos="fade-in" delay="800" data-aos-duration="1000"><a class="thumbnail two" href="#"></a></li>
            <li data-aos="fade-in" delay="800" data-aos-duration="1000"><a class="thumbnail three" href="#"></a></li>
            <li data-aos="fade-in" delay="800" data-aos-duration="1000"><a class="thumbnail four" href="#"></a></li>
            <li data-aos="fade-in" delay="800" data-aos-duration="1000"><a class="thumbnail five" href="#"></a></li>
            <li data-aos="fade-in" delay="800" data-aos-duration="1000"><a class="thumbnail six" href="#"></a></li>
            </ul>
        </div>
        <div class="car-type escalade d-none">
            <div class="main-img"><img class="img-responsive" src="<?= $assets->baseUrl; ?>/img/banner_cars_optic_4.jpg" alt=""></div>
            <ul class="list-inline mb-0">
            <li><a class="thumbnail one" href="#"></a></li>
            <li><a class="thumbnail two" href="#"></a></li>
            <li><a class="thumbnail three" href="#"></a></li>
            <li><a class="thumbnail four" href="#"></a></li>
            <li><a class="thumbnail five" href="#"></a></li>
            <li><a class="thumbnail six" href="#"></a></li>
            </ul>
        </div>
        </div>
    </div>
    <div class="row contact">
        <div class="col-sm-6 col-md-4 col-md-offset-2" data-aos="fade-right" data-aos-duration="4000" data-aos-delay="200">
        <h2 data-aos="fade-up" data-aos-easing="ease-in-out">CONTACTO</h2><a class="mail" href="mailto:info@opticpt.com">info@opticpt.com</a><a href="tel:(52) 624 130 6373"><i class="fas fa-phone icon"></i>(52) 624 130 6373</a><a href="#"><i class="fas fa-map-marker-alt icon"></i>Cabo San Lucas Col.Centro 23477</a>
        </div>
        <div class="col-sm-6 col-md-4" data-aos="fade-left" data-aos-duration="4000" data-aos-delay="200">
        <form class="my-5" action="">
            <div class="form-group">
            <input class="form-control" type="text" placeholder="Nombre">
            </div>
            <div class="form-group">
            <input class="form-control" type="text" placeholder="Correo electrónico">
            </div>
            <div class="form-group">
            <textarea class="form-control" name="" cols="30" rows="5" placeholder="Mensaje"></textarea>
            </div>
            <input class="btn btn-default pull-right" type="submit" value="ENVIAR">
        </form>
        </div>
    </div>
    </div>
</div>