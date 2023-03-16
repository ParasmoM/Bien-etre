const swiper = new Swiper(".mySwiper", {
    cssMode: true,
    slidesPerView: 1,
    spaceBetween: 30,
    loop: true,
    autoplay : {
        delay: 2500,
        disableOnInteraction : false,
    },
    mousewheel: true,
    keyboard: true,

    navigation: {
        nextEl: ".swiper-button-next",
        prevEl: ".swiper-button-prev",
    },
});