/*
 * Welcome to your app's main JavaScript file!
 *
 * We recommend including the built version of this JavaScript file
 * (and its CSS file) in your base layout (base.html.twig).
 */

// any CSS you import will output into a single css file (app.css in this case)
import './styles/general/app.css';

// start the Stimulus application
import './bootstrap';

// ====== CONST & GLOBAL VARIABLES ======
const borderRadiusArray = [
    '30% 60% 70% 40% / 50% 60% 30% 60%',
    '60% 40% 30% 70% / 60% 30% 70% 40%',
    '40% 60% 60% 40% / 60% 30% 70% 40%', '60% 40% 40% 60% / 30% 60% 40% 70%', '78% 22% 51% 49% / 35% 52% 48% 65%', '55% 45% 28% 72% / 70% 45% 55% 30%', '22% 78% 49% 51% / 52% 35% 65% 48%', '45% 55% 72% 28% / 45% 70% 30% 45%', '60% 40%', '40% 60%',
];

function randomBorder() {
    return borderRadiusArray[Math.floor(Math.random() * borderRadiusArray.length)];
}

const professionnalsBlocks = document.querySelectorAll('.pro-block');
const bubblesProfessionnals = document.querySelectorAll('.bubble-pro');
const servicesBlocks = document.querySelectorAll('.service-block');
const bubblesServices = document.querySelectorAll('.bubble-service');
const blockReferences = document.querySelectorAll('.reference-block');
const bubblesReferences = document.querySelectorAll('.bubble-reference');
const footer = document.querySelector('.footer-others');
const burgerMenu = document.querySelector('.responsive-menu');
const burgherIcon = document.querySelector('.burger-icon');
const lineOne = document.querySelector('.line1');
const lineTwo = document.querySelector('.line2');
const lineThree = document.querySelector('.line3');
const explicationTitre = document.querySelectorAll('.explication-titre p');
const utilisation = document.getElementById('utilisation');
const portraitRobert = document.querySelector('.R');
const portraitAlice = document.querySelector('.A');
const portraitPatrick = document.querySelector('.P');

burgherIcon.addEventListener('click', () => {
    burgerMenu.classList.toggle('change');
    lineOne.classList.toggle('rotateOne');
    lineTwo.classList.toggle('byby');
    lineThree.classList.toggle('rotateThree');
});

window.addEventListener('scroll', () => {
    const scrollValue = (window.innerHeight + window.scrollY) / (document.body.offsetHeight);

    if (scrollValue > 0.48) {
        utilisation.style.animation = 'moveInBottom 1.5s ease';
        utilisation.style.animationFillMode = 'forwards';
    }

    if (scrollValue > 0.645) {
        portraitRobert.style.transitionDelay = '1s';
        portraitRobert.style.animation = 'moveInLeft 1.5s ease';
        portraitRobert.style.animationFillMode = 'forwards';
    }

    if (scrollValue > 0.75) {
        portraitAlice.style.transitionDelay = '1s';
        portraitAlice.style.animation = 'moveInLeft 1.5s ease';
        portraitAlice.style.animationFillMode = 'forwards';
    }

    if (scrollValue > 0.86) {
        portraitPatrick.style.transitionDelay = '1s';
        portraitPatrick.style.animation = 'moveInLeft 1.5s ease';
        portraitPatrick.style.animationFillMode = 'forwards';
    }

    if (scrollValue > 0.9) {
        footer.style.animation = 'moveFooter 0.8s 0.3s ease';
        footer.style.animationFillMode = 'backwards';
    }
});

for (let i = 0; i < explicationTitre.length; i += 1) {
    explicationTitre[i].style.transitionDelay = `${i / 2}s`;
    explicationTitre[i].classList.add('appear');
}

for (let i = 0; i < servicesBlocks.length; i += 1) {
    servicesBlocks[i].style.transitionDelay = `${i / 5}s`;
    servicesBlocks[i].classList.add('appear');
}

for (let i = 0; i < bubblesServices.length; i += 1) {
    bubblesServices[i].style.borderRadius = randomBorder();
}

for (let i = 0; i < professionnalsBlocks.length; i += 1) {
    professionnalsBlocks[i].style.transitionDelay = `${i / 5}s`;
    professionnalsBlocks[i].classList.add('appear');
}

for (let i = 0; i < bubblesProfessionnals.length; i += 1) {
    bubblesProfessionnals[i].style.borderRadius = randomBorder();
}

for (let i = 0; i < blockReferences.length; i += 1) {
    blockReferences[i].style.transitionDelay = `${i / 5}s`;
    blockReferences[i].classList.add('appear');
}

for (let i = 0; i < bubblesReferences.length; i += 1) {
    bubblesReferences[i].style.borderRadius = randomBorder();
}
