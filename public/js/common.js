const footer = document.querySelector('.footer'),
      spakrs = document.querySelector('.sparks-wrapper'),
      notesBlock = document.querySelectorAll('.notes__block'),
      newsPageAccs = document.querySelectorAll('.news-page__accs-item'),
      roadmapBlocks = document.querySelectorAll('.cards__item'),
      roadmapList = document.querySelector('.roadmap__list'),
      closeBtns = document.querySelectorAll('.card__close');

if (closeBtns) {
  closeBtns.forEach(btn => {
    btn.addEventListener('click', () => {
      btn.parentElement.classList.toggle('cards__item--active');
    })
  })
}


if (notesBlock) {
  notesBlock.forEach(block => {
    block.addEventListener('click', function(e) {

      if (e.target.parentNode !== document.querySelector('.delete')) {
        this.classList.toggle('collapse');
      }

      const hiddenBlock = this.querySelector('.notes__block-inner');
      const hiddenBlockHeight = hiddenBlock.scrollHeight;

        if (this.classList.contains('collapse')) {
          hiddenBlock.style.maxHeight = `${hiddenBlockHeight}px`;
        } else {
          hiddenBlock.style.maxHeight = 0;
        }
    })
  })
}

if (newsPageAccs) {
  newsPageAccs.forEach(block => {
    block.addEventListener('click', function() {

      this.classList.toggle('news-page__accs-item--active');

      const hiddenBlock = this.querySelector('.news-page__accs-hidden');
      const hiddenBlockHeight = hiddenBlock.scrollHeight;

        if (this.classList.contains('news-page__accs-item--active')) {
          hiddenBlock.style.maxHeight = `${hiddenBlockHeight}px`;
        } else {
          hiddenBlock.style.maxHeight = 0;
        }
    })
  })
}

function setSpakrs() {
  const footerHeight = footer.clientHeight;
  spakrs.style.bottom = `${footerHeight}px`;
}

setSpakrs();
