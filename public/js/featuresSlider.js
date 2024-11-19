const cards = new Swiper('.features__inner', {
  spaceBetween: 24,
  slidesPerView: 1,
  loop: true,
  navigation: {
    nextEl: '.features__arrow_next',
    prevEl: '.features__arrow_prev'
  },
  breakpoints: {
    768: {
      slidesPerView: 2
    },
    1150: {
      slidesPerView: 3
    },
    1300: {
      slidesPerView: 4
    }
  }
})
