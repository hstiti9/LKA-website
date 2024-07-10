const navIcon = document.getElementById('nav-icon');

const navbar = document.getElementById('nav');

navbar.style.transition = 'background-color 0.3s, box-shadow 0.3s'; 
navbar.style.boxShadow = '0 2px 5px rgba(0, 0, 0, 0.5)';
navbar.style.backgroundColor = 'rgba(255, 255, 255, 0.6)';
navbar.style.backdropFilter = 'blur(10px)';
navIcon.src = "../images/nav-icon - Copy.png";


document.getElementById('nav-icon').addEventListener('click', function() {
  var nav = document.getElementById('popup-nav');
  nav.classList.toggle('show');
});

function hideNav() {
  var nav = document.getElementById('popup-nav');
  nav.classList.remove('show');
}

function applyAlternateBackground() {
    const eventDivs = document.querySelectorAll('.event');
    eventDivs.forEach((div, index) => {
        if (index % 2 === 0) {
            div.style.backgroundColor = 'rgb(250,250,250)';
        } else {
            div.style.backgroundColor = 'rgb(235,235,235)';
        }
    });
}

applyAlternateBackground();