jQuery(document).ready(function ($) {
  $(".carousel-wrapper").slick({
    infinite: true,
    autoplay: true,
    autoplaySpeed: 4000,
    dots: true,
    arrows: true,
    slidesToShow: 1,
    adaptiveHeight: true,
  });
});
