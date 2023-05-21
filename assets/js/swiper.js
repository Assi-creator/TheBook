new Swiper('.carousel-review', {
    direction: 'horizontal',
    navigation:{
        nextEl: '.next-carousel',
        prevEl: '.prev-carousel'
    },
    slidesPerGroup: 3,
    slidesPerView: 3
});

new Swiper('.carousel-book', {
    navigation:{
        nextEl: '.next-carousel',
        prevEl: '.prev-carousel'
    },
    loop: true,
    slidesPerGroup: 2,
    slidesPerView: 5
});