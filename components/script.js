
// Nav bar
let isScrolled = false;

// Hover effect for login button icon
const button = document.querySelector('.login-button');
const icon = document.getElementById('login-icon');

button.addEventListener('mouseenter', () => {
  icon.src = 'images/login-gray.svg';
});

button.addEventListener('mouseleave', () => {
  icon.src = isScrolled ? 'images/login-white.svg' : 'images/login-black.svg';
});

// Scroll handler
function handleScroll() {
  const navbar = document.getElementById('mainNavbar');
  const navbarBrand = document.getElementById('navBrand');
  const appointmentBtn = document.getElementById('appointmentButton');
  const loginBtn = document.getElementById('loginButton');
  const navLinkIDs = ['home', 'about', 'providers', 'services', 'contact'];

  // Update scroll state
  isScrolled = window.scrollY > 50;

  // Toggle custom classes
  navbar?.classList.toggle('navbar-scrolled', isScrolled);
  navbarBrand?.classList.toggle('text-light', isScrolled);
  appointmentBtn?.classList.toggle('appointment-button-scrolled', isScrolled);
  loginBtn?.classList.toggle('login-button-scrolled', isScrolled);

  navLinkIDs.forEach(id => {
    const link = document.getElementById(id);
    link?.classList.toggle('text-light', isScrolled);
  });

  // ✅ Toggle Bootstrap dark classes
  if (isScrolled) {
    navbar?.classList.add('navbar-dark', 'bg-dark');
    navbar?.classList.remove('navbar-light', 'bg-light'); // remove light version if used
  } else {
    navbar?.classList.remove('navbar-dark', 'bg-dark');
    navbar?.classList.add('navbar-light', 'bg-light'); // optional default style
  }

  // Update icon if not hovering
  if (!button.matches(':hover')) {
    icon.src = isScrolled ? 'images/login-white.svg' : 'images/login-black.svg';
  }
}

// Attach scroll listener
window.addEventListener('scroll', handleScroll);
handleScroll(); // Run once on page load

// Doctors carousel
const swiper = new Swiper('.mySwiper', {
      loop: true,
      spaceBetween: 30,
      slidesPerView: 'auto',
      navigation: {
        nextEl: '.swiper-button-next',
        prevEl: '.swiper-button-prev',
      },
      pagination: {
        el: '.swiper-pagination',
        clickable: true,
      },
      breakpoints: {
        0: {
          slidesPerView: 1,
        },
        768: {
          slidesPerView: 2,
        },
        992: {
          slidesPerView: 3,
        },
      }
    });