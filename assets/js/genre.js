
const block = document.querySelectorAll(".genre-block");
block.forEach((item) => {
    console.log(item)
    item.querySelector('#subgenre-a').addEventListener("click", (event) => {
        const clickedItem = event.target;

        let genreArrow = item.querySelector(".arrow-genre-down");
        if (genreArrow) {
            genreArrow.classList.remove("arrow-genre-down");
            genreArrow.classList.add("arrow-genre-up");
            item.querySelector('.carousel-right').classList.add("width-full")
            item.querySelector('.subgenre-left').classList.add("width-full")
            item.querySelector('#subgenre-more').style.display = 'none';
            item.querySelector('#subgenres-span').style.display = null;
        } else {
            genreArrow = item.querySelector(".arrow-genre-up");
            genreArrow.classList.remove("arrow-genre-up");
            genreArrow.classList.add("arrow-genre-down");
            item.querySelector('.carousel-right').classList.remove("width-full")
            item.querySelector('.subgenre-left').classList.remove("width-full")
            item.querySelector('#subgenre-more').style.display = null;
            item.querySelector('#subgenres-span').style.display = 'none';
        }


        console.log(`Вы кликнули на элементе с id ${clickedItem.id}`);
    });
});

new Swiper('.carousel-genre-books', {
    //Стрелки
    navigation:{
        nextEl: '.next-carousel',
        prevEl: '.prev-carousel'
    },

    //Навигация
    pagination: {
        el: '.swiper-pagination',
        clickable: true,
    },
    slidesPerGroup: 5,
    slidesPerView: 11
});
