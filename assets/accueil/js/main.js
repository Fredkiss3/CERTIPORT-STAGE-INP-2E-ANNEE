$(document).ready(function () {
    $('.owl-carousel').owlCarousel({
        loop:false,
        rewind: true,
        autoplay: true,
        autoplaySpeed: 1000,
        margin:10,
        nav:false,
        responsive:{
            0:{
                items:1
            },
            600:{
                items:3
            },
            1000:{
                items:8
            }
        }
    })
});