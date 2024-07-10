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

global_id = "";
global_name = "";
global_price = "";

// Function to show the reservation form
function showReservationForm(id, name, price) {
    const Form = document.getElementById('reservation');
    const ID = document.getElementById('hidden');
    const Title = document.getElementById('form-header');
    
    Form.classList.toggle('show');
    if(window.innerWidth<650){
        Form.style.marginTop = window.scrollY + 50 + 'px';
    }
    ID.value = id;
    Title.innerHTML = `Reserver "${name}"`;

    // Use global variables to store the current product information
    window.global_id = id;
    window.global_name = name;
    window.global_price = price;

    // Initialize the total price calculation
    updateTotalPrice();
}

// Function to update the total price based on the quantity
function updateTotalPrice() {
    const quantityInput = document.getElementById('quantité');
    const Total = document.getElementById('total');
    const quantity = parseInt(quantityInput.value, 10);

    // Validate the quantity
    if (isNaN(quantity) || quantity < 1) {
        Total.innerHTML = "<p>Prix Totale:</p>";
    } else {
        const totalPrice = (window.global_price * quantity).toFixed(2);
        Total.innerHTML = `<p>Prix Totale: ${totalPrice} DT</p>`;
    }
}

// Function to hide the reservation form
function hideReservationForm() {
    const Form = document.getElementById('reservation');
    Form.classList.remove('show');
}

document.addEventListener('DOMContentLoaded', function () {
    // Function to get URL parameters
    function getUrlParameter(name) {
        name = name.replace(/[\[]/, '\\[').replace(/[\]]/, '\\]');
        var regex = new RegExp('[\\?&]' + name + '=([^&#]*)');
        var results = regex.exec(location.search);
        return results === null ? '' : decodeURIComponent(results[1].replace(/\+/g, ' '));
    }

    // Check for 'error_message' or 'success_message' in the URL
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

    // Close popup on click of the close button
    popupCloseElement.addEventListener('click', function () {
        popupMessageElement.style.display = 'none';
    });

    // Close popup when clicking outside of the content
    window.addEventListener('click', function (event) {
        if (event.target === popupMessageElement) {
            popupMessageElement.style.display = 'none';
        }
    });
});



