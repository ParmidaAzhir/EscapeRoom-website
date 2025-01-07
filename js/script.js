

document.querySelectorAll('a[href^="#"]').forEach(link => {
   link.addEventListener('click', function(e) {
      e.preventDefault();
      let target = document.querySelector(this.getAttribute('href'));
      if (target) {
         window.scrollTo({
            top: target.offsetTop,
            behavior: 'smooth'
         });
      }
   });
})