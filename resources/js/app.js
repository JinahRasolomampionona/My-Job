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

import $ from 'jquery';
// import 'malihu-custom-scrollbar-plugin/jquery.mCustomScrollbar.css';
// import 'malihu-custom-scrollbar-plugin/jquery.mCustomScrollbar';

// $(document).ready(function () {
//     $(".scrollbar-container").mCustomScrollbar({
//         theme: "dark" // Tu peux changer le thème (light, minimal, etc.)
//     });
// });

import Alpine from 'alpinejs';

window.Alpine = Alpine;

Alpine.start();
