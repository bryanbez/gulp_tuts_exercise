//import App from './modules/app.js';
import 'code-prettify';

//const app = new App();

window.addEventListener("load", function() {
    console.log('load');

    PR.prettyPrint();

    const tabs = document.querySelectorAll("ul.nav-tabs > li");

    for (var i = 0; i < tabs.length; i++) {
        tabs[i].addEventListener("click", function(event) {
            event.preventDefault();

            document.querySelector("ul.nav-tabs li.active").classList.remove("active");
            document.querySelector(".tab-pane.active").classList.remove("active");

            const clickedTab = event.currentTarget;
            const anchor = event.target;
            const activePaneID = anchor.getAttribute("href");

            clickedTab.classList.add("active");
            document.querySelector(activePaneID).classList.add("active");
        });
    }
});

jQuery(document).ready(function($) {

    console.log('anr');

    $('.js-image-upload').on('click', function(e) {

        e.preventDefault();

        var $button = $(this);

        var file_frame = wp.media.frames.file_frame = wp.media({

            title: 'Select or Upload an Image to display in widgets',

            library: {

                type: 'image'
            },

            button: {

                text: 'Select Image'
            },

            multiple: false //prevent selecting multiple images

        });

        file_frame.on('select', function() {

            var imageUrl = file_frame.state().get('selection').toJSON();

            $button.siblings('.image-upload').val(imageUrl[0].url); // paste the image url in textbox

        });

        file_frame.open();

    });


});