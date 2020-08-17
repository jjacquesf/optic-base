<?php
use frontend\assets\ThemeAsset;
use yii\helpers\Url;

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
            <a href="<?= Url::to(['/site/search-travel']); ?>" class="btn btn-info btn-sm pull-right">
                <i class="fas fa-search"></i> Buscar mi reserva
            </a>
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
                <li class="model-link" class="model-link"><a href="#" data-target_id="#escalade">ESCALADE</a></li>
                <li class="model-link"><a href="#" data-target_id="#gl500">GL 500</a></li>
                <li class="model-link"><a href="#" data-target_id="#suburvan">SUBURBAN</a></li>
                <li class="model-link"><a href="#" data-target_id="#sprinter">SPRINTER</a></li>
                <li class="model-link"><a href="#" data-target_id="#vclass">V CLASS</a></li>
                <li class="model-link"><a href="#" data-target_id="#tesla">MODEL X</a></li>
            </ul>
            <div id="vclass" class="car-type vclass">
                <div class="main-img" data-aos="fade-up" data-aos-easing="ease-in-out"><img class="img-responsive" src="<?= $assets->baseUrl; ?>/img/VCLASS.jpg" alt=""><a class="btn btn-primary reserve" href="#">RESERVAR</a></div>
                <ul class="list-inline mb-0">
                <li><a class="thumbnail one" data-lightbox="vclass" href="<?= $assets->baseUrl; ?>/img/IMG_7787_optic.jpg"></a></li>
                <li data-aos="fade-in" delay="800" data-aos-duration="1000"><a class="thumbnail two" data-lightbox="vclass" href="<?= $assets->baseUrl; ?>/img/IMG_7787_optic.jpg"></a></li>
                <li data-aos="fade-in" delay="800" data-aos-duration="1000"><a class="thumbnail three" data-lightbox="vclass" href="<?= $assets->baseUrl; ?>/img/IMG_7794_optic.jpg"></a></li>
                <li data-aos="fade-in" delay="800" data-aos-duration="1000"><a class="thumbnail four" data-lightbox="vclass" href="<?= $assets->baseUrl; ?>/img/IMG_7798_optic.jpg"></a></li>
                <li data-aos="fade-in" delay="800" data-aos-duration="1000"><a class="thumbnail five" data-lightbox="vclass" href="<?= $assets->baseUrl; ?>/img/IMG_7811_optic.jpg"></a></li>
                <li data-aos="fade-in" delay="800" data-aos-duration="1000"><a class="thumbnail six" data-lightbox="vclass" href="<?= $assets->baseUrl; ?>/img/IMG_7824_optic.jpg"></a></li>
                </ul>
            </div>
            <div id="escalade" class="car-type escalade">
                <div class="main-img"><img class="img-responsive" src="<?= $assets->baseUrl; ?>/img/ESCALADE_V2.jpg" alt=""></div>
                <ul class="list-inline mb-0">
                <li><a class="thumbnail one"></a></li>
                <li><a class="thumbnail two" data-lightbox="escalade" href="<?= $assets->baseUrl; ?>/img/escalade/big/1.jpg"></a></li>
                <li><a class="thumbnail three" data-lightbox="escalade" href="<?= $assets->baseUrl; ?>/img/escalade/big/2.jpg"></a></li>
                <li><a class="thumbnail four" data-lightbox="escalade" href="<?= $assets->baseUrl; ?>/img/escalade/big/3.jpg"></a></li>
                <li><a class="thumbnail five" data-lightbox="escalade" href="<?= $assets->baseUrl; ?>/img/escalade/big/4.jpg"></a></li>
                <li><a class="thumbnail six" data-lightbox="escalade" href="<?= $assets->baseUrl; ?>/img/escalade/big/5.jpg"></a></li>
                </ul>
            </div>
            <div id="gl500" class="car-type escalade">
                <div class="main-img"><img class="img-responsive" src="<?= $assets->baseUrl; ?>/img/GL500_V2.jpg" alt=""></div>
                <ul class="list-inline mb-0">
                <li><a class="thumbnail one" data-lightbox="gl500" href="<?= $assets->baseUrl; ?>/img/gl500/big/1.jpg"></a></li>
                <li><a class="thumbnail two" data-lightbox="gl500" href="<?= $assets->baseUrl; ?>/img/gl500/big/2.jpg"></a></li>
                <li><a class="thumbnail three" data-lightbox="gl500" href="<?= $assets->baseUrl; ?>/img/gl500/big/3.jpg"></a></li>
                <li><a class="thumbnail four" data-lightbox="gl500" href="<?= $assets->baseUrl; ?>/img/gl500/big/4.jpg"></a></li>
                <li><a class="thumbnail five" data-lightbox="gl500" href="<?= $assets->baseUrl; ?>/img/gl500/big/5.jpg"></a></li>
                <li><a class="thumbnail six" data-lightbox="gl500" href="<?= $assets->baseUrl; ?>/img/gl500/big/6.jpg"></a></li>
                </ul>
            </div>
            <div id="suburvan" class="car-type escalade">
                <div class="main-img"><img class="img-responsive" src="<?= $assets->baseUrl; ?>/img/SUBURVAN_V2.jpg" alt=""></div>
                <ul class="list-inline mb-0">
                <li><a class="thumbnail one" data-lightbox="suburvan" href="<?= $assets->baseUrl; ?>/img/suburvan/big/1.jpg"></a></li>
                <li><a class="thumbnail two" data-lightbox="suburvan" href="<?= $assets->baseUrl; ?>/img/suburvan/big/2.jpg"></a></li>
                <li><a class="thumbnail three" data-lightbox="suburvan" href="<?= $assets->baseUrl; ?>/img/suburvan/big/3.jpg"></a></li>
                <li><a class="thumbnail four" data-lightbox="suburvan" href="<?= $assets->baseUrl; ?>/img/suburvan/big/4.jpg"></a></li>
                <li><a class="thumbnail five" data-lightbox="suburvan" href="<?= $assets->baseUrl; ?>/img/suburvan/big/5.jpg"></a></li>
                <li><a class="thumbnail six" data-lightbox="suburvan" href="<?= $assets->baseUrl; ?>/img/suburvan/big/6.jpg"></a></li>
                </ul>
            </div>
            <div id="sprinter" class="car-type escalade">
                <div class="main-img"><img class="img-responsive" src="<?= $assets->baseUrl; ?>/img/SPRINTER_V2.jpg" alt=""></div>
                <ul class="list-inline mb-0">
                <li><a class="thumbnail one" data-lightbox="sprinter" href="<?= $assets->baseUrl; ?>/img/sprinter/big/1.jpg"></a></li>
                <li><a class="thumbnail two" data-lightbox="sprinter" href="<?= $assets->baseUrl; ?>/img/sprinter/big/2.jpg"></a></li>
                <li><a class="thumbnail three" data-lightbox="sprinter" href="<?= $assets->baseUrl; ?>/img/sprinter/big/3.jpg"></a></li>
                <li><a class="thumbnail four" data-lightbox="sprinter" href="<?= $assets->baseUrl; ?>/img/sprinter/big/4.jpg"></a></li>
                <li><a class="thumbnail five" data-lightbox="sprinter" href="<?= $assets->baseUrl; ?>/img/sprinter/big/5.jpg"></a></li>
                <li><a class="thumbnail six" data-lightbox="sprinter" href="<?= $assets->baseUrl; ?>/img/sprinter/big/6.jpg"></a></li>
                </ul>
            </div>
            <div id="tesla" class="car-type escalade">
                <div class="main-img"><img class="img-responsive" src="<?= $assets->baseUrl; ?>/img/TESLA.jpg" alt=""></div>
                <ul class="list-inline mb-0">
                <li><a class="thumbnail one" data-lightbox="modelx" href="<?= $assets->baseUrl; ?>/img/modelx/1m.jpg"></a></li>
                <li><a class="thumbnail two" data-lightbox="modelx" href="<?= $assets->baseUrl; ?>/img/modelx/2m.jpg"></a></li>
                <li><a class="thumbnail three" data-lightbox="modelx" href="<?= $assets->baseUrl; ?>/img/modelx/3m.jpg"></a></li>
                <li><a class="thumbnail four" data-lightbox="modelx" href="<?= $assets->baseUrl; ?>/img/modelx/4m.jpg"></a></li>
                <li><a class="thumbnail five" data-lightbox="modelx" href="<?= $assets->baseUrl; ?>/img/modelx/5m.jpg"></a></li>
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