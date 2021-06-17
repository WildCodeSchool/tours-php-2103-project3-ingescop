/*
 * Welcome to your app's main JavaScript file!
 *
 * We recommend including the built version of this JavaScript file
 * (and its CSS file) in your base layout (base.html.twig).
 */

// any CSS you import will output into a single css file (app.css in this case)
import './styles/app.css';

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

const bubblesProfessionnals = document.querySelectorAll('.bubble-pro');
const bubblesServices = document.querySelectorAll('.bubble-service');

for (let i = 0; i < bubblesProfessionnals.length; i += 1) {
    bubblesProfessionnals[i].style.borderRadius = randomBorder();
    bubblesProfessionnals[i].style.transitionDelay = `${i / 5}s`;
    bubblesProfessionnals[i].classList.add('appear');
}

for (let i = 0; i < bubblesServices.length; i += 1) {
    bubblesServices[i].style.borderRadius = randomBorder();
    bubblesServices[i].style.transitionDelay = `${i / 5}s`;
    bubblesServices[i].classList.add('appear');
}
