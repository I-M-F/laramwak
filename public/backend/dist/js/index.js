


let navbar = document.getElementById("main-nav");
let navPos = navbar.getBoundingClientRect().top;
let navbarLinks = document.querySelectorAll("nav a");

window.addEventListener("scroll", e => {
  
  let scrollPos = window.scrollY;
  if (scrollPos > navPos) {
    navbar.classList.add('sticky');
    header.classList.add('navbarOffsetMargin');
  } else {
    navbar.classList.remove('sticky');
    header.classList.remove('navbarOffsetMargin');
  }
  
    navbarLinks.forEach(link => {
      let section = document.querySelector(link.hash);
      if (scrollPos + 150 > section.offsetTop && scrollPos + 150 < section.offsetTop + section.offsetHeight ) {
        link.classList.add("active");
      } else {
        link.classList.remove("active");
      }
    });
});

