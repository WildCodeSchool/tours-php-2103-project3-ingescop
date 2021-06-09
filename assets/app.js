/*
 * Welcome to your app's main JavaScript file!
 *
 * We recommend including the built version of this JavaScript file
 * (and its CSS file) in your base layout (base.html.twig).
 */

// any CSS you import will output into a single css file (app.css in this case)
import './styles/app.css';

// start the Stimulus application
// import './bootstrap';

// ====== CONST & GLOBAL VARIABLES ======
const borderRadiusArray = [
    '30% 60% 70% 40% / 50% 60% 30% 60%',
    '60% 40% 30% 70% / 60% 30% 70% 40%',
    '40% 60% 60% 40% / 60% 30% 70% 40%', '60% 40% 40% 60% / 30% 60% 40% 70%',
    '60% 40%', '40% 60%',
];

function randomBorder() {
    return borderRadiusArray[Math.floor(Math.random() * borderRadiusArray.length)];
}

const bubblesProfessionnals = document.querySelectorAll('.bubble-pro');
const bubblesServices = document.querySelectorAll('.bubble-service');

for (let i = 0; i < bubblesProfessionnals.length; i += 1) {
    bubblesProfessionnals[i].style.borderRadius = randomBorder();
}

for (let i = 0; i < bubblesServices.length; i += 1) {
    bubblesServices[i].style.borderRadius = randomBorder();
}
