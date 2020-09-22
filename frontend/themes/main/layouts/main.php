<?php 
  
  use yii\helpers\Html;
  use yii\widgets\Menu;
  use frontend\assets\ThemeAsset;

  $assets = ThemeAsset::register($this);

?><?php $this->beginPage() ?><!DOCTYPE html>
<html lang="<?= Yii::$app->language; ?>">
  <head>
    <meta name="charset" charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="user-scalable=no, initial-scale=1, maximum-scale=1, minimum-scale=1, width=device-width">
    <meta name="title" content="">
    <meta name="description" content="">
    <meta name="keywords" content="">
    <meta name="robots" content="index, follow">
    <meta name="author" content="http://www.lava.mx">
    <meta name="distribution" content="global">
    <meta name="rating" content="general">
    <meta name="revisit-after" content="14 Days">
    <title><?= Html::encode($this->title) ?></title>
    <link rel="icon" type="image/png" href="<?= sprintf('%s/img/favicon.png', $assets->baseUrl); ?>" />
    <?= Html::csrfMetaTags() ?>
    <?php $this->head() ?>
  </head>
  <body>
    <header class="Header <?= Yii::$app->session->getFlash('special-class', ''); ?>">
      <div class="container-fluid">
        <div class="row">
          <div class="col-sm-12 text-center">
            <div class="desktop">
            <a class="logo" href="/"><img src="<?= sprintf('%s/img/LOGO_2_OPTIC.png', $assets->baseUrl); ?>" alt="Optic"><span class="slogan">Los Cabos Premium Service</span></a>
              <div class="right">
              <?= Menu::widget([
                            'options' => ['class' => 'list-inline top-menu'],
                            'encodeLabels' => false,
                            'itemOptions' => ['class' => 'text-uppercase'],
                            'items' => [
                                // ['label' => '<i class="fas fa-phone mr-3"></i> 01 52 (624) 130 6373', 'url' => 'tel:01526241306373', 'options' => []],
                                // ['label' => '|', 'url' => false],
                                ['label' => '<i class="fas fa-phone mr-3"></i> 01 52 (624) 157 8132', 'url' => 'tel:01526241578132', 'options' => []],
                                ['label' => Html::img(sprintf('%s/img/lang-es.jpg', $assets->baseUrl), ['class' => 'img-responsive lang']), 'url' => ['/'], 'options' => []],
                                ['label' => Html::img(sprintf('%s/img/lang-eu.jpg', $assets->baseUrl), ['class' => 'img-responsive lang']), 'url' => ['/'], 'options' => []],
                            ]
                        ]); ?>
                <!-- <ul class="list-inline top-menu">
                  <li><a href="tel:01 52 (624) 130 6373"><i class="fas fa-phone mr-3"></i>01 52 (624) 130 6373 |</a></li>
                  <li><a href="tel:01 52 (624) 157 8132">01 52 (624) 157 8132</a></li>
                  <li><a href="#"><img class="img-responsive lang" src="assets/img/lang-es.jpg" alt="Optic"></a></li>
                  <li><a href="#"><img class="img-responsive lang" src="assets/img/lang-eu.jpg" alt="Optic"></a></li>
                </ul> -->
                <?= Menu::widget([
                            'options' => ['class' => 'list-inline'],
                            'itemOptions' => ['class' => 'text-uppercase'],
                            'linkTemplate' => '<a href="{url}" class="anchor">{label}</a>',
                            'items' => [
                                ['label' => Yii::t('app', 'Reservar'), 'url' => '#reservar', 'options' => []],
                                ['label' => Yii::t('app', 'Servicios'), 'url' => '#servicios', 'options' => []],
                                ['label' => Yii::t('app', 'Vehículos'), 'url' => '#vehiculos', 'options' => []],
                                ['label' => Yii::t('app', 'Nosotros'), 'url' => '#nosotros', 'options' => []],
                                ['label' => Yii::t('app', 'Contácto'), 'url' => '#contacto', 'options' => []],

                            ]
                        ]); ?>
                <!-- <ul class="list-inline">
                  <li><a href="product-general.html">NOSOTROS</a></li>
                  <li><a href="product-general.html">SERVICIOS</a></li>
                  <li><a href="product.html">VEHÍCULOS</a></li>
                  <li><a href="product.html">RESERVACIÓN</a></li>
                  <li><a href="product.html">CONTACTO</a></li>
                </ul> -->
              </div>
            </div>
            <div class="header-mobil">
            <div class="icons">
              <a href="#"><img class="img-responsive" src="<?= sprintf('%s/img/lang-es.jpg', $assets->baseUrl); ?>" alt="Optic"></a>
              <a class="x-2" href="#"><img class="img-responsive" src="<?= sprintf('%s/img/lang-eu.jpg', $assets->baseUrl); ?>" alt="Optic"></a>
            </div>
            <a class="logo" href="/"><img class="img-responsive" src="<?= sprintf('%s/img/LOGO_2_OPTIC.png', $assets->baseUrl); ?>" alt="Optic"></a>
            <a class="open-menu" href="#" target="_blank"><i class="fas fa-bars"></i></a>
            </div>
            <?= Menu::widget([
                        'options' => ['class' => 'mobil'],
                        'encodeLabels' => false,
                        'itemOptions' => ['class' => 'text-uppercase'],
                        'items' => [
                            ['label' => Yii::t('app', 'Nosotros'), 'url' => ['/'], 'options' => []],
                            ['label' => Yii::t('app', 'Servicios'), 'url' => ['/'], 'options' => []],
                            ['label' => Yii::t('app', 'Vehículos'), 'url' => ['/'], 'options' => []],
                            ['label' => Yii::t('app', 'Reservación'), 'url' => ['/'], 'options' => []],
                            ['label' => Yii::t('app', 'Contácto'), 'url' => ['/'], 'options' => []],
                            // ['label' => 'tel:01526241306373', 'url' => '<i class="fas fa-phone mr-3"></i>01 52 (624) 130 6373', 'options' => []],
                            ['label' => 'tel:01526241578132', 'url' => '<i class="fas fa-phone mr-2"></i> 01 52 (624) 157 8132', 'options' => []],

                        ]
                    ]); ?>
            <!-- <ul class="mobil">
              <li><a href="product-general.html">NOSOTROS</a></li>
              <li><a href="product-general.html">SERVICIOS</a></li>
              <li><a href="product.html">VEHÍCULOS</a></li>
              <li><a href="product.html">RESERVACIÓN</a></li>
              <li><a href="product.html">CONTACTO</a></li>
              <li><a class="phone" href="tel:01 52 (624) 130 6373"><i class="fas fa-phone mr-2"></i>01 52 (624) 130 6373</a></li>
              <li><a class="phone" href="tel:01 52 (624) 157 8132"><i class="fas fa-phone mr-2"></i>01 52 (624) 157 8132</a></li>
            </ul> -->
          </div>
        </div>
      </div>
    </header>
    <?= $content; ?>
    <footer class="container-fluid">
      <div class="row">
        <div class="col-md-8 col-md-offset-2">
          <div class="top"><img class="img-responsive logo" src="<?= sprintf('%s/img/LOGO_2_OPTIC.png', $assets->baseUrl); ?>" alt="Optic Logo"><span class="slogan">Los Cabos Premium Service</span>
            <div class="languague">
                <?= Menu::widget([
                            'options' => ['class' => 'list-inline'],
                            'itemOptions' => ['class' => 'text-uppercase'],
                            'items' => [
                                ['label' => Yii::t('app', 'Español'), 'url' => ['/'], 'options' => []],
                                ['label' => Yii::t('app', 'English'), 'url' => ['/'], 'options' => []],
                            ]
                        ]); ?>
              <!-- <ul class="list-inline">
                <li><a href="#">ESPAÑOL |</a></li>
                <li><a href="#">ENGLISH</a></li>
              </ul> -->
            </div>
            <div class="social-media">
            <?= Menu::widget([
                            'options' => ['class' => 'list-inline'],
                            'encodeLabels' => false,
                            // 'itemOptions' => ['class' => 'text-uppercase'],
                            'items' => [
                                ['label' => '<i class="fab fa-youtube"></i>', 'url' => 'http://www.google.com', 'options' => []],
                                ['label' => '<i class="fab fa-twitter"></i>', 'url' => 'http://www.google.com', 'options' => []],
                                ['label' => '<i class="fab fa-facebook-f"></i>', 'url' => 'http://www.google.com', 'options' => []],
                                ['label' => '<i class="fab fa-instagram"></i>', 'url' => 'http://www.google.com', 'options' => []],
                            ]
                        ]); ?>
              <!-- <ul class="list-inline">
                <li><a href="#"><i class="fab fa-youtube"></i></a></li>
                <li><a href="#"><i class="fab fa-twitter"></i></a></li>
                <li><a href="#"><i class="fab fa-facebook-f"></i></a></li>
                <li><a href="#"><i class="fab fa-instagram"></i></a></li>
              </ul> -->
            </div>
          </div>
          <div class="center">
            <div class="footer-menu menu-one">
              <p>Nosotros</p>
              <!-- <ul>
                <li><a href="#">Nuestra Historia</a></li>
                <li><a href="#">Política de Servicio</a></li>
                <li><a href="#">Socios Comerciales</a></li>
                <li><a href="#">Videos corporativos</a></li>
              </ul> -->
              <?= Menu::widget([
                    'options' => ['class' => ''],
                    // 'itemOptions' => ['class' => 'text-uppercase'],
                    'items' => [
                        ['label' => Yii::t('app', 'Nuestra Historia'), 'url' => ['/'], 'options' => []],
                        ['label' => Yii::t('app', 'Política de Servicio'), 'url' => ['/'], 'options' => []],
                        ['label' => Yii::t('app', 'Socios Comerciales'), 'url' => ['/'], 'options' => []],
                        ['label' => Yii::t('app', 'Videos corporativos'), 'url' => ['/'], 'options' => []],
                    ]
                ]); ?>
            </div>
            <div class="footer-menu menu-two">
              <p>Servicios</p>
              <!-- <ul>
                <li><a href="#">Transportación Privada</a></li>
                <li><a href="#">Transportación Colectiva</a></li>
                <li><a href="#">Seguro</a></li>
              </ul> -->
              <?= Menu::widget([
                    'options' => ['class' => ''],
                    // 'itemOptions' => ['class' => 'text-uppercase'],
                    'items' => [
                        ['label' => Yii::t('app', 'Transportación Privada'), 'url' => ['/'], 'options' => []],
                        ['label' => Yii::t('app', 'Transportación Colectiva'), 'url' => ['/'], 'options' => []],
                        ['label' => Yii::t('app', 'Seguro'), 'url' => ['/'], 'options' => []],
                    ]
                ]); ?>
            </div>
            <div class="footer-menu menu-three">
              <p>Vehículos</p><a href="#">Nuestros vehículos</a>
            </div>
            <div class="footer-menu menu-four">
              <p>Reservación</p><a href="#">Reserva tu vehículo</a>
            </div>
          </div>
          <div class="bottom">
          <?= Menu::widget([
                    'options' => ['class' => 'list-inline'],
                    // 'itemOptions' => ['class' => 'text-uppercase'],
                    'items' => [
                        ['label' => Yii::t('app', 'Política de Privacidad'), 'url' => ['/'], 'options' => []],
                        ['label' => '|', 'url' => false, 'options' => []],
                        ['label' => Yii::t('app', 'Derechos Reservados Optic Private Transportation'), 'url' => ['/'], 'options' => []],
                    ]
                ]); ?>
            <!-- <ul class="list-inline">
              <li><a href="#">Política de Privacidad |</a></li>
              <li><a href="#">Derechos Reservados Optic Private Transportation</a></li>
            </ul> -->
            <div class="company"><span>Sitio diseñado por</span><img width="60" src="<?= $assets->baseUrl; ?>/img/eskalon.png" alt="Eskalon" class="ml-3"></div>
          </div>
        </div>
      </div>
    </footer>
    <!-- GetButton.io widget -->
    <script type="text/javascript">
        (function () {
            var options = {
                whatsapp: "+52 1 624 121 3559", // WhatsApp number
                call_to_action: "Message us", // Call to action
                position: "right", // Position may be 'right' or 'left'
            };
            var proto = document.location.protocol, host = "getbutton.io", url = proto + "//static." + host;
            var s = document.createElement('script'); s.type = 'text/javascript'; s.async = true; s.src = url + '/widget-send-button/js/init.js';
            s.onload = function () { WhWidgetSendButton.init(host, proto, options); };
            var x = document.getElementsByTagName('script')[0]; x.parentNode.insertBefore(s, x);
        })();
    </script>
    <!-- /GetButton.io widget -->
    <?php $this->endBody() ?>
  </body>
</html><?php $this->endPage() ?>