const dropdowns = document.querySelectorAll('.dropdowns__item');

dropdowns.forEach(item => {
  item.addEventListener('click', function() {
    item.classList.toggle('collapse-hidden')
  })
})

// dropdowns.forEach(dr => {
//   dr.addEventListener('click', function() {
//     // dropdowns.forEach(item => item.classList.remove('collapse-hidden'));
//   })
// })
