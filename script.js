document.addEventListener("DOMContentLoaded", function() {
// SLIDER

var slides = document.getElementsByClassName("slide");
var pagination = document.getElementsByClassName("slider-pagination")[0];
var currentSlide = 0;
var slideInterval = setInterval(nextSlide, 4000); // Défilement automatique toutes les 4 secondes

function createPagination() {
  for (var i = 0; i < slides.length; i++) {
    var paginationItem = document.createElement("div");
    paginationItem.classList.add("slider-pagination-item");
    paginationItem.setAttribute("data-index", i); // Ajout de l'attribut "data-index" pour chaque élément de la pagination
    paginationItem.addEventListener("click", function() {
      clearInterval(slideInterval);
      selectSlide(parseInt(this.getAttribute("data-index"))); // Utilisation de l'index de l'élément de la pagination cliqué
    });
    pagination.appendChild(paginationItem);
  }
}

function showSlide(slideIndex) {
  if (slideIndex >= 0 && slideIndex < slides.length) {
    slides[currentSlide].classList.remove("active");
    pagination.getElementsByClassName("slider-pagination-item")[currentSlide].classList.remove("active");
    currentSlide = slideIndex;
    slides[currentSlide].classList.add("active");
    pagination.getElementsByClassName("slider-pagination-item")[currentSlide].classList.add("active");
  }
}

function nextSlide() {
  showSlide((currentSlide + 1) % slides.length);
}

function previousSlide() {
  showSlide((currentSlide - 1 + slides.length) % slides.length);
}

function selectSlide(index) {
  showSlide(index);
  startSlideInterval();
}

var sliderArrowRight = document.getElementsByClassName("slider-arrow-right")[0];
var sliderArrowLeft = document.getElementsByClassName("slider-arrow-left")[0];

if (sliderArrowRight) {
    sliderArrowRight.addEventListener("click", function() {
        clearInterval(slideInterval);
        nextSlide();
        startSlideInterval();
    });
}

if (sliderArrowLeft) {
    sliderArrowLeft.addEventListener("click", function() {
        clearInterval(slideInterval);
        previousSlide();
        startSlideInterval();
    });
}


function startSlideInterval() {
  clearInterval(slideInterval);
  slideInterval = setInterval(nextSlide, 4000);
}

createPagination();
showSlide(currentSlide);
startSlideInterval();
// fin code SLIDER

// Code menu burger
var nav = document.querySelector('.headerPrincipal nav');

if(nav){
  document.querySelector('.burger-menu').addEventListener('click', function() {
    const nav = document.querySelector('.headerPrincipal nav');
    nav.classList.toggle('active');
  });
}
// fin code menu burger

// fonction scroll to top

let button = document.querySelector('.scrollButton');

// Apparition du bouton au scroll
function scrollFunction() {
    if(document.body.scrollTop > 20 || document.documentElement.scrollTop > 20) {
      button.style.display = "block";
    } else {
      button.style.display = "none";
    }
}

window.onscroll = function() {
  scrollFunction();
}

// Scroll Top au click
if(button){
  button.addEventListener('click', topFunction);
}

function topFunction() {
  document.documentElement.scrollTo({
    top: 0,
    behavior: 'smooth'
  });
}




// fonction pop-up cookies

let popup = document.getElementsByClassName('pop-up')[0];
let buttonPopUp = document.getElementById('buttonPopUp');

function displayPopUp() {
  if (popup) {
    popup.style.display = "none";
    sessionStorage.setItem('popupClosed', 'true');
  }
}

if (popup) {
  if (sessionStorage.getItem('popupClosed') === 'true') {
      popup.style.display = "none";
  }
}

if (buttonPopUp) {
  buttonPopUp.addEventListener('click', () => {
      displayPopUp();
  });
}


// fonction pour confirmer suppression actualité, activité ou vidéo

let deleteButtons = document.querySelectorAll('.boutonSupprimer');

deleteButtons.forEach(function(button) {
    button.addEventListener("click", function(e) {
        if (!confirm("Êtes-vous sûr de vouloir supprimer cet élément ?")) {
            e.preventDefault();
        }
    });
});


});

document.addEventListener("DOMContentLoaded", function() {
  let notification = document.getElementById("notificationEmail");
  let urlParams = new URLSearchParams(window.location.search);
  let emailSent = urlParams.get("emailSent");

  if (emailSent === "1") {
      notification.innerText = "L'email a été envoyé avec succès !";
      notification.classList.add("success");
  } else if (emailSent === "0") {
      notification.innerText = "Erreur lors de l'envoi de l'email.";
      notification.classList.add("error");
  } else {
      notification.style.display = "none"; // Masquer la notification si aucune information n'est disponible
  }

  setTimeout(function() {
      notification.style.display = "none";
  }, 3000); // Masquer la notification après 3 secondes
});

