// bundle.config.js
module.exports = {
  bundle: {
    vendor: {
      scripts: [
        // './bower_components/jquery/dist/jquery.js',
        // './bower_components/bootstrap/dist/js/bootstrap.js',
        './bower_components/matchHeight/dist/jquery.matchHeight.js',
        './bower_components/owl.carousel/dist/owl.carousel.js',
        // './bower_components/sticky.js/dist/sticky.js',
        // './bower_components/enquire/dist/enquire.js',
        // './bower_components/elevatezoom/jquery.elevateZoom-2.2.3.js',
        './bower_components/nano/nano.js',
        './bower_components/numeral/numeral.js',
        './bower_components/numeral/locales.js',
        './bower_components/slider-pro/dist/js/jquery.sliderPro.js',
        './bower_components/magnify/dist/js/jquery.magnify.js',
        './bower_components/aos/dist/aos.js',
        './bower_components/clockpicker/dist/bootstrap-clockpicker.min.js',
        // './bower_components/pnotify/dist/pnotify.js',
        // './bower_components/iCheck/icheck.js'
      ],
      styles: [
        './bower_components/bootstrap/dist/css/bootstrap.css',
        './bower_components/slider-pro/dist/css/slider-pro.css',
        './bower_components/owl.carousel/dist/assets/owl.carousel.css',
        './bower_components/owl.carousel/dist/assets/owl.theme.default.css',
        './bower_components/magnify/dist/css/magnify.css',
        './bower_components/aos/dist/aos.css',
        './bower_components/clockpicker/dist/bootstrap-clockpicker.min.css',
        // './bower_components/pnotify/dist/pnotify.css',
        // './bower_components/pnotify/dist/pnotify.brighttheme.css',
        // './bower_components/iCheck/skins/minimal/minimal.css',
        // './bower_components/iCheck/skins/minimal/purple.css',
        // './dev/css/fa.css'
      ],
      options: {
        uglify: false,
        minCSS: false,
        rev: false
      }
    },
    main: {
      scripts: [
        './dev/js/**/*.js'
      ],
      styles: [
      	'./dev/css/style.css',
        './dev/css/webfont.css'
      ],
      options: {
        rev: false
      }
    }
  },
  copy: [
    {
      src: './dev/**/*.{jpg,png,gif}',
      base: './dev'
    },
    {
      src: './dev/**/*.{eot,svg,ttf,woff,woff2,otf}',
      base: './dev'
    }
  ]
};
