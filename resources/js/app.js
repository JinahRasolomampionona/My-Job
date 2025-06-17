import './bootstrap';
import.meta.glob([
    '../images/**',
    '../fonts/**',
]);

import 'bootstrap/dist/css/bootstrap.min.css';  // Pour le CSS
import 'bootstrap'; // Pour le JavaScript (inclut Popper.js)

import AOS from 'aos';
import 'aos/dist/aos.css'; // Importer le CSS de AOS

// Initialisation de AOS
AOS.init();

//Quilljs editor
import Quill from "quill";
import "quill/dist/quill.snow.css"; // Import du style par défaut

document.addEventListener("DOMContentLoaded", function () {
    let quill = new Quill("#editor", {
        theme: "snow",
        placeholder: "Ecrivez ici...",
        modules: {
            toolbar: [
                [{ font: [] }, { size: [] }],
                [{ header: [1, 2, false] }],
                ["bold", "italic", "underline", "strike"],
                [{ script: "sub" }, { script: "super" }],
                [{ color: [] }, { background: [] }],
                [{ list: "ordered" }, { list: "bullet" }],
                [{ indent: "-1" }, { indent: "+1" }],
                [{ align: [] }],
                ["blockquote", "code-block"],
                ["link", "image", "video"],
                ["clean"]
            ],
        },
    });

    // Insérer la description existante dans Quill
    let existingDescription = document.querySelector("#hidden-description").value;
    quill.root.innerHTML = existingDescription;

    // Mettre à jour l'input caché
    quill.on("text-change", function () {
        document.querySelector("#hidden-description").value = quill.root.innerHTML;
    });

    // S'assurer que la valeur est envoyée avant la soumission du formulaire
    document.querySelector("form").onsubmit = function () {
        document.querySelector("#hidden-description").value = quill.root.innerHTML;
    };
});

let title = document.getElementById('title');
let i = 0;
setInterval(() => {

    const mot = "Notre job, vous aider à choisir le vôtre parmi 150,77 offres";

    let span = document.createElement('span');

    span.innerText = mot.charAt(i);
    title.append(span);
    i++;

    if (i > mot.length) {
        title.style.borderRight = 'none';
    }
}, 100)

/*Collapse sidebar*/
const toggleSidebar = document.getElementById('toggleSidebar');
const sidebar = document.getElementById('sidebar');
const topNavbar = document.getElementById('topNavbar');
const contentWrapper = document.getElementById('contentWrapper');

toggleSidebar.addEventListener('click', () => {
    sidebar.classList.toggle('collapsed');
    topNavbar.classList.toggle('collapsed');
    contentWrapper.classList.toggle('collapsed');
});

// Ouvrir/Fermer le sidebar au clic du bouton (hamburger)
document.getElementById('toggleSidebar').addEventListener('click', function () {
    document.querySelector('.sidebar').classList.toggle('show');
});

// Fermer le sidebar lorsqu'un lien est cliqué (en version mobile)
const sidebarLinks = document.querySelectorAll('.sidebar');

sidebarLinks.forEach(link => {
    link.addEventListener('click', function () {
        if (window.innerWidth < 768) {
            document.querySelector('.sidebar').classList.remove('show');
        }
    });
});

const popoverTriggerList = document.querySelectorAll('[data-bs-toggle="popover"]');
popoverTriggerList.forEach(popoverTriggerEl => {
    new bootstrap.Popover(popoverTriggerEl);
});

// Activer les tooltips Bootstrap
const tooltipTriggerList = document.querySelectorAll('[data-bs-toggle="tooltip"]');
tooltipTriggerList.forEach(t => new bootstrap.Tooltip(t));

import $ from 'jquery';

import Alpine from 'alpinejs';

window.Alpine = Alpine;

Alpine.start();
