document.addEventListener('DOMContentLoaded', function() {
    const navIcon = document.getElementById('nav-icon');
    const navbar = document.getElementById('nav');
    const wrapper2 = document.getElementById('wrapper2');
    const sliderContainer = document.getElementById('container');
    const sliderDotsContainer = document.getElementById('sliderDots');
    const flexerContainer = document.getElementById('flexerContainer');
    const loc = document.getElementById('location');
    const lycée = document.getElementById('lycée-img');
    const kheireddineImage = document.getElementById('kheireddine-image');
    const popupNav = document.getElementById('popup-nav');
    const closeNavButton = document.getElementById('x');
    let currentSlide = 0;
    let timer;

    async function fetchEvents() {
        const response = await fetch('includes/fetch_events.php');
        const events = await response.json();
        return events;
    }

    async function loadEvents() {
        const events = await fetchEvents();
        const container = document.getElementById('container');

        if (container) {
            const eventSlides = events.map((event, index) => `
                <div id="slide${index+1}" class="slider">
                    <a href=""><img class="slider-image" src="data:image/jpeg;base64,${event.event_img}" alt="${event.event_name}"></a>
                </div>
            `).join('');

            container.innerHTML = eventSlides;

            const slide1 = document.getElementById('slide1');
            const slide2 = document.getElementById('slide2');
            const slide3 = document.getElementById('slide3');

            updateWidth(); 
        } else {
            console.error('Element with ID "container" not found');
        }
    }

    loadEvents();

    function changeNavbarBackground() {
        if (window.scrollY > 0) {
            navbar.style.transition = 'background-color 0.3s, box-shadow 0.3s'; 
            navbar.style.boxShadow = '0 2px 5px rgba(0, 0, 0, 0.5)';
            navbar.style.backgroundColor = 'rgba(255, 255, 255, 0.6)';
            navbar.style.backdropFilter = 'blur(10px)';
            navIcon.src = "../images/nav-icon - Copy.png";
        } else {
            navbar.style.backgroundColor = 'rgba(0, 0, 0, 0)';
            navbar.style.backdropFilter = 'blur(0)'; 
            navbar.style.transition = 'background-color 0.3s, box-shadow 0.3s';
            navbar.style.boxShadow = 'none';
            navIcon.src = "../images/nav-icon.png";
        }
    }

    window.addEventListener('scroll', changeNavbarBackground, { passive: true });

    function showNav() {
        popupNav.classList.toggle('show');
    }

    function hideNav() {
        popupNav.classList.remove('show');
    }

    navIcon.addEventListener('click', showNav);
    closeNavButton.addEventListener('click', hideNav);

    function updateWidth() {
        const slide1 = document.getElementById('slide1');
        const slide2 = document.getElementById('slide2');
        const slide3 = document.getElementById('slide3');

        if (!slide1 || !slide2 || !slide3) {
            console.error('One or more slide elements not found in the DOM during updateWidth');
            return;
        }

        let width = flexerContainer.clientWidth;
        slide1.style.height = (width * 3/4) + 'px';
        slide2.style.height = (width * 3/4) + 'px';
        slide3.style.height = (width * 3/4) + 'px';
        sliderContainer.style.height = (width * 3/4) + 'px';
        wrapper2.style.height = (width * 3/4) + 'px';

        wrapper2.style.width = width + 'px';
        slide1.style.width = width + 'px';
        slide2.style.width = width + 'px';
        slide3.style.width = width + 'px';
        sliderContainer.style.width = (width * 3) + 'px';

        let width2 = lycée.clientWidth;
        lycée.style.height = width2 + 'px';
        loc.style.width = width2 + 'px';
        loc.style.height = width2 + 'px';

        updateSlider(); 
    }

    window.addEventListener('resize', updateWidth);

    function createSliderDots() {
        for (let i = 0; i < 3; i++) {
            const dot = document.createElement('div');
            dot.classList.add('dot');
            sliderDotsContainer.appendChild(dot);
        }

        updateSliderDots();
    }

    function nextSlide() {
        currentSlide = (currentSlide + 1) % 3;
        updateSlider();
        updateSliderDots();
        restartTimer();
    }

    function prevSlide() {
        currentSlide = (currentSlide - 1 + 3) % 3;
        updateSlider();
        updateSliderDots();
        restartTimer();
    }

    function updateSlider() {
        const slide1 = document.getElementById('slide1');
        if (!slide1) {
            console.error('slide1 not found in updateSlider');
            return;
        }

        const width = slide1.clientWidth;
        const translateValue = -currentSlide * width;
        sliderContainer.style.transform = `translateX(${translateValue + width}px)`;
    }

    function restartTimer() {
        clearInterval(timer);
        timer = setInterval(nextSlide, 5000);
    }

    function updateSliderDots() {
        const dots = document.querySelectorAll('.slider-dots .dot');
        dots.forEach((dot, index) => {
            if (index === currentSlide) {
                dot.style.backgroundColor = 'rgb(255,255,255)';
            } else {
                dot.style.backgroundColor = 'rgb(200,200,200)';
            }
        });
    }

    createSliderDots();
    restartTimer();

    function setImage() {
        const width = window.innerWidth;

        if (width > 992) {
            kheireddineImage.src = '../images/Kheireddine_Pacha_high.JPG';
        } else {
            kheireddineImage.src = '../images/Kheireddine_Pacha_(2 by 3).JPG';
        }
    }

    setImage();
    window.addEventListener('resize', setImage);
});
