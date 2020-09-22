$( document ).ready(function() {

    $( '#home-slider' ).sliderPro({
        width: '100%',
        height: 700,
        arrows: false,
        buttons: true,
        waitForLayers: true,
        autoplay: false,
        autoplayDelay: 6000,
        autoScaleLayers: false,
        touchSwipe: false,
        fade: true,
        breakpoints: {
            480: {
                height: 400
            },
            768: {
                height: 500
            }
        }
    });

    $('#product-item').owlCarousel({
      nav: true,
      dots: false,
      loop: true,
      responsive: {
        0: {
          nav: false,
          dots: true,
          items: 1
        },
        320: {
          nav: false,
          dots: true,
          items: 1
        },
        480: {
          nav: false,
          dots: true,
          items: 2
        },
        768: {
          nav: true,
          dots: false,
          items: 3
        },
        992: {
          nav: true,
          dots: false,
          items: 4
        }
      }
    });
    $( ".owl-prev").html('<i class="fas fa-chevron-left"></i>');
    $( ".owl-next").html('<i class="fas fa-chevron-right"></i>');

    $('a.anchor[href^="#"]').on("click", function(o) {
      if (!$(this).hasClass("exclude")) {
          o.preventDefault();
          var e = this.hash,
              a = $(e);
              
          $("html, body").stop().animate({
              scrollTop: a.offset().top - 75
          }, 900, "swing", function() {})
      }
    });

    //Open Mobil Menu
    $('.open-menu').click(function(e){
      e.preventDefault();

      $('.mobil').slideToggle('fast');
    });

    // showModel();

    $('.model-link a').on('click', function(e) {
      
      e.preventDefault();

      $('.model-link').removeClass('active');
      $(this).parent().addClass('active');

      var target = $(this).data('target_id');
      $('.car-type').hide();
      $(target).show();
      console.log('target', target);

    });

    $('a', $('.model-link').first()).trigger('click');

    AOS.init();

});

// function showModel() {
//   event.preventDefault();

//   var target = $(this).data('target_id');
//   $('.car-type').hide();
//   $(target).show();
//   console.log('target', target);

  // var modelVCLASS = $('.vclass');
  // var modelESCALADE = $('.escalade');

  // if (clickedId == 'VCLASS') {

  //   if (modelVCLASS.hasClass('d-none')) {
  //     $(modelVCLASS).removeClass('d-none');
  //     $(modelESCALADE).addClass('d-none');
  //   }

  // }

  // if (clickedId == 'ESCALADE') {

  //   if (modelESCALADE.hasClass('d-none')) {
  //     $(modelESCALADE).removeClass('d-none');
  //     $(modelVCLASS).addClass('d-none');
  //   }

  // }
// }
