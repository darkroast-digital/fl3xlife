// *************************************************************************
// *************************************************************************
// *************************************************************************

require('./bootstrap');

$(window).on('load', function(){
    $('.loading-page').removeClass('is--loading');
    $('.home').addClass('is--loaded');
    $('.error').addClass('is--loaded');
});


// #ACCODION
// =========================================================================

$('.accordion__content').hide();
$('.accordion__content').first().show();
$('.accordion__panel').first().addClass('is--open');

$('.accordion__title').click(function() {
    $('.accordion__panel').removeClass('is--open');
    $(this).parent().addClass('is--open');
    $('.accordion__content').slideUp(200);
    $(this).next('.accordion__content').slideDown(200);
});



// #TABS
// =========================================================================

$('li[data-tab], .tabs__content').first().addClass('is--active');
$('.tabs__content').first().addClass('is--active');

$('li[data-tab]').click(function() {
    var thisTab = $(this).attr('data-tab');
    var tab = $('.tabs__content' + '[data-tab="' + thisTab + '"]');

    $('li[data-tab]').removeClass('is--active');
    $(this).addClass('is--active');
    $('.tabs__content').removeClass('is--active');
    tab.addClass('is--active');
});




// #DROPDOWN
// =========================================================================

$('.dropdown').mouseenter(function() {
    $(this).addClass('is--active');
});

$('.dropdown').mouseleave(function() {
    $(this).removeClass('is--active');
});

$('.dropdown-menu').mouseleave(function() {
    $(this).parent().removeClass('is--active');
});




// #ALERT NOTIFY
// =========================================================================

$('.alert--notify').click(function() {
    $(this).fadeOut(200);
});



// #OFF CANVAS
// =========================================================================

var offCanvasTrigger = $('.off-canvas__trigger');
var offCanvas = $('.off-canvas');

if (offCanvasTrigger) {
    offCanvasTrigger.on('click', function () {
        offCanvas.addClass('is--open');
        overlay.addClass('is--active');
    });
}

var adminOffCanvasTrigger = $('.admin-off-canvas__trigger');
var adminOffCanvas = $('.admin-off-canvas');

if (adminOffCanvasTrigger) {
    adminOffCanvasTrigger.on('click', function () {
        adminOffCanvas.addClass('is--open');
        overlay.addClass('is--active');
    });
}

$('.off-canvas button').on('click', function () {
    offCanvas.removeClass('is--open');
})



// #MODAL
// =========================================================================

var modalTrigger = $('.modal__trigger');
var modal = $('.modal');

modalTrigger.click(function(){
    var thisModal = $(this).data('modal');
    var modal = $(`.modal[data-modal="${ thisModal }"]`);
    modal.addClass('is--open');
    $('.overlay').addClass('is--active');
    $('body').css('overflow', 'hidden');
});

$(".close").on("click", function() {
    $(".modal").removeClass('is--open');
    $('.overlay').removeClass('is--active');
    $('body').css('overflow', 'scroll');
});




// #KEY CONTROL
// =========================================================================

$(document).keyup(function(e) {
    if (e.keyCode === 27) {
        overlay.removeClass('is--active');
    }
});

if (offCanvas) {

    $(document).keyup(function(e) {
        if (e.keyCode === 27) {
            offCanvas.removeClass('is--open');
        }
    });

}

if (adminOffCanvas) {

    $(document).keyup(function(e) {
        if (e.keyCode === 27) {
            adminOffCanvas.removeClass('is--open');
        }
    });

}

if (modal) {

    $(document).keyup(function(e) {
        if (e.keyCode === 27) {
            modal.removeClass('is--open');
            $('body').css('overflow', 'scroll');
        }
    });

}



// #OVERLAY
// =========================================================================

var overlay = $('.overlay');

if (overlay) {
    overlay.on('click', function () {
        $(this).removeClass('is--active');
    });
}

if (overlay) {
    overlay.on('click', function () {
        $('.off-canvas').removeClass('is--open');
        $('.admin-off-canvas').removeClass('is--open');
    });
}

if (overlay) {
    overlay.on('click', function () {
        $('.modal').removeClass('is--open');
        $('body').css('overflow', 'scroll');
    });
}



// #EMAIL FORM
// =========================================================================

var form = $('.contact-form');

$(form).submit(function(e) {
  e.preventDefault();

  var formData = new FormData($(this)[0]);

  //if files => formData.append('file', $('input[type=file]')[0].files[0]);

  $.ajax({
    type: 'post',
    url: $(this).attr('action'),
    data: formData,
    processData: false,
    contentType: false
  })
  .done(function (response) {
    $('input').val('');
    $('textarea').val('');
    $('<div class="alert is-success">Your Message Was Sent! We\'ll be in touch.</div>').insertAfter(form);
    
    console.log('success' + response);
  })
  .fail(function (data) {
    $('input').val('');
    $('textarea').val('');
    $('<div class="alert is-error">Oh no! Something went wrong, try again.</div>').insertAfter(form);
    
    console.log('fail' + data);
  })

});




// #CAROUSELS
// =========================================================================

$('.hero-carousel').slick({
    dots: false,
    arrows: false,
    autoplay: true,
    infinite: true,
    autoplaySpeed: 9000,
    slidesToShow: 1,
    slidesToScroll: 1,
    draggable:false,
});

$('.slick-dots button').empty();


$('.trainer__container').slick({
    dots: false,
    arrows: true,
    autoplay: true,
    infinite: true,
    autoplaySpeed: 9000,
    slidesToShow: 4,
    slidesToScroll: 4,
    draggable:false,
    responsive: [
        {
          breakpoint: 1025,
          settings: {
            slidesToShow: 3,
            slidesToScroll: 3,
            draggable:true
          }
        },
        {
          breakpoint: 769,
          settings: {
            slidesToShow: 2,
            slidesToScroll: 2
          }
        },
        {
          breakpoint: 513,
          settings: {
            slidesToShow: 1,
            slidesToScroll: 1
          }
        }
    ]
});

$('.slick-dots button').empty();
$('.slick-prev').html("<i class=\"fa fa-chevron-left\"></i>");
$('.slick-next').html("<i class=\"fa fa-chevron-right\"></i>");



$('.testimonies__container').slick({
    dots: false,
    arrows: true,
    autoplay: true,
    infinite: true,
    autoplaySpeed: 9000,
    slidesToShow: 1,
    slidesToScroll: 1,
    draggable:false,
});

$('.slick-dots button').empty();
$('.slick-prev').html("<i class=\"fa fa-angle-left\"></i>");
$('.slick-next').html("<i class=\"fa fa-angle-right\"></i>");




// #INSTAGRAM FEED
// =========================================================================

var userFeed = new Instafeed({
  get: 'user',
  userId: '6658374205',
  accessToken: '6658374205.c31c536.f8dc966c41004a10bbce7df3e4e81a44',
  resolution: 'standard_resolution',
  limit: 6,
  sort: 'most-recent',
  template: '<a href="{{link}}" target="_blank"><img src="{{image}}" /></a>',
});

userFeed.run();




// #SCROLLING
// =========================================================================

$('a[href^="#"]').on('click', function(event) {
    var target = $(this.getAttribute('href'));
    if( target.length ) {
        event.preventDefault();
        $('html, body').stop().animate({
            scrollTop: target.offset().top
        }, 1000);
    }
});

$('.go-back').on('click', function() {
    window.history.back();
});




// #IMAGE PREVIEW
// =========================================================================

function readURL(input) {
    if (input.files && input.files[0]) {
        var reader = new FileReader();

        reader.onload = function(e) {
            $('.image-preview').attr('src', e.target.result);
        }

        reader.readAsDataURL(input.files[0]);
    }
}

$('.image-upload input').change(function() {
    $(this).parent().find('span').hide();
    readURL(this);
    $('.image-preview').show();
});




// #ALERT FADE OUT
// =========================================================================

$('.alert').delay(6000).fadeOut("slow");




// #HIDE HERO BUTTON
// =========================================================================

$('#buttonDisplay').change(function(){
    if ($(this).prop('checked') == true) {
        $('.button-options').addClass('hidden-option');
        $('.button-options').prop('disabled', true);
    } else {
        $('.button-options').removeClass('hidden-option');
        $('.button-options').prop('disabled', false);
    }
})




// #SIMPLE MDE
// =========================================================================

var mde = document.getElementById('mde')

if (mde) {
    var simplemde = new SimpleMDE({ 
        element: mde,
        hideIcons: [
            'fullscreen',
            'side-by-side'
        ]
    });
}