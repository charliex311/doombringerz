const closeIcon = document.querySelector('.menu__close'),
      burger = document.querySelector('.header__burger'),
      navLinks = document.querySelectorAll('.menu-nav__link'),
      menu = document.querySelector('.menu'),
      body = document.body,
      html = document.documentElement,
      menuDropdown = document.querySelector('.menu-dropdown'),
      menuDropdownTrigger = document.querySelector('.menu-nav__item_dropdown');

menuDropdownTrigger.addEventListener('click', function(){
  this.classList.toggle('active-dropdown')
  menuDropdown.classList.toggle('collapse-menu-dropdown')
})

function closeMenuByClick() {
  if (navLinks.length > 0) {
    navLinks.forEach(link => {
      link.addEventListener('click', closeMenu);
    })
  }
}
closeMenuByClick();

function showMenu() {
  closeIcon.classList.remove('closed')
  burger.classList.toggle('active-burger');
  body.classList.add('body-locked')
  if (burger.classList.contains('active-burger')) {
    menu.classList.add('show-menu')
    body.classList.add('body-locked')
    html.classList.add('body-locked')
  } else {
    menu.classList.remove('show-menu')
    body.classList.remove('body-locked')
    html.classList.remove('body-locked');
  }
}

function closeMenu() {
  closeIcon.classList.add('closed');
  menu.classList.remove('show-menu');
  burger.classList.remove('active-burger');
  body.classList.remove('body-locked')
  html.classList.remove('body-locked');
}

if (burger) {
  closeIcon.addEventListener('click', closeMenu);
}

if (burger) {
  burger.addEventListener('click', showMenu);
}
