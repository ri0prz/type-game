// Header media query
const mobileBar = document.querySelector('.mobile-effect');
const slideBar = document.querySelector('nav .right');

mobileBar.onclick = () => {
   mobileBar.classList.toggle('active');
   slideBar.classList.toggle('active');
}