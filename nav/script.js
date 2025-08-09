// search-box open close js code
let searchBox = document.querySelector(".search-box .bx-search");
// let searchBoxCancel = document.querySelector(".search-box .bx-x");

searchBox.addEventListener("click", ()=>{
  navbar.classList.toggle("showInput");
  if(navbar.classList.contains("showInput")){
    searchBox.classList.replace("bx-search" ,"bx-x");
  }else {
    searchBox.classList.replace("bx-x" ,"bx-search");
  }
});
let navbar = document.querySelector(".navbar");
// sidebar open close js code
let navLinks = document.querySelector(".nav-links");
let menuOpenBtn = document.querySelector(".navbar .bx-menu");
let menuCloseBtn = document.querySelector(".nav-links .bx-x");
menuOpenBtn.onclick = function() {
navLinks.style.left = "0";
}
menuCloseBtn.onclick = function() {
navLinks.style.left = "-100%";
}


// sidebar submenu open close js code
let kategorieArrow = document.querySelector(".kategorie-arrow");
kategorieArrow.onclick = function() {
 navLinks.classList.toggle("show4");
}

let produktyArrow = document.querySelector(".produkty-arrow");
produktyArrow.onclick = function() {
 navLinks.classList.toggle("show5");
}

let czlonkowieArrow = document.querySelector(".czlonkowie-arrow");
czlonkowieArrow.onclick = function() {
 navLinks.classList.toggle("show6");
}
let spizarnieArrow = document.querySelector(".spizarnie-arrow");
spizarnieArrow.onclick = function() {
 navLinks.classList.toggle("show7");
}


//let htmlcssArrow = document.querySelector(".htmlcss-arrow");
//htmlcssArrow.onclick = function() {
// navLinks.classList.toggle("show1");
//}

let jsArrow = document.querySelector(".js-arrow");
jsArrow.onclick = function() {
 navLinks.classList.toggle("show3");
}