const navIcon = document.getElementById('nav-icon');

const navbar = document.getElementById('nav');

navbar.style.transition = 'background-color 0.3s, box-shadow 0.3s'; 
navbar.style.boxShadow = '0 2px 5px rgba(0, 0, 0, 0.5)';
navbar.style.backgroundColor = 'rgba(255, 255, 255, 0.6)';
navbar.style.backdropFilter = 'blur(10px)';
navIcon.src = "../images/nav-icon - Copy.png";


function showNav(){
  var nav = document.getElementById('popup-nav');
  nav.classList.toggle('show');
};

function hideNav() {
  var nav = document.getElementById('popup-nav');
  nav.classList.remove('show');
}




function applyAlternateBackground() {
    const clubDivs = document.querySelectorAll('.club');
    clubDivs.forEach((div, index) => {
        if (index % 2 === 0) {
            div.style.backgroundColor = 'rgb(250,250,250)';
        } else {
            div.style.backgroundColor = 'rgb(235,235,235)';
        }
    });
}

applyAlternateBackground();



global_id = "";
global_name = "";

function showApplicationForm(id, name) {
    const Form = document.getElementById('application');
    const ID = document.getElementById('hidden');
    const Title = document.getElementById('form-header');
    if(window.innerWidth<650){
        Form.style.marginTop = window.scrollY + 50 + 'px';
    }
    
    window.global_id = id;
    window.global_name = name;

    Form.classList.toggle('show');
    ID.value = id;
    Title.innerHTML = `S'inscrire au "${name}"`;
}

function hideApplicationForm() {
    const Form = document.getElementById('application');
    Form.classList.remove('show');
}



document.addEventListener('DOMContentLoaded', function () {
    function getUrlParameter(name) {
        name = name.replace(/[\[]/, '\\[').replace(/[\]]/, '\\]');
        var regex = new RegExp('[\\?&]' + name + '=([^&#]*)');
        var results = regex.exec(location.search);
        return results === null ? '' : decodeURIComponent(results[1].replace(/\+/g, ' '));
    }

    const errorMessage = getUrlParameter('error_message');
    const successMessage = getUrlParameter('success_message');
    const popupMessageElement = document.getElementById('popup-message');
    const popupTextElement = document.getElementById('popup-text');
    const popupCloseElement = document.getElementById('popup-close');

    if (errorMessage) {
        popupMessageElement.classList.add('error');
        popupMessageElement.classList.remove('success');
        popupTextElement.innerHTML = `<strong>ERREUR:</strong> ${errorMessage}`;
        popupMessageElement.style.display = 'flex';
    } else if (successMessage) {
        popupMessageElement.classList.add('success');
        popupMessageElement.classList.remove('error');
        popupTextElement.innerHTML = `<strong>SUCCÈS:</strong> ${successMessage}`;
        popupMessageElement.style.display = 'flex';
    }

    popupCloseElement.addEventListener('click', function () {
        popupMessageElement.style.display = 'none';
    });

    window.addEventListener('click', function (event) {
        if (event.target === popupMessageElement) {
            popupMessageElement.style.display = 'none';
        }
    });
});
