const sp_nav = document.querySelector('.sp-nav');
const menu_btn = document.querySelector('.menu-btn');

menu_btn.addEventListener('click',() => {
  // menu_btn.classList.toggle('active');
  // sp_nav.classList.toggle('active');

  $('.header-bottom').slideToggle();
})

window.addEventListener('resize',() => {
  if(window.innerWidth >= 1024) {
    $('.header-bottom').hide();
  }
})
