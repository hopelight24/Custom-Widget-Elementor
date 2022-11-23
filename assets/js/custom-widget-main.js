var heading = document.querySelectorAll(".acc-heading");
var width = window.outerWidth;
/* start for loop */
for (var i = 0; i < heading.length; i++) {

    heading[i].addEventListener("click", accordion); 
        function accordion() {
            var panel = this.nextElementSibling;
            panel.classList.toggle("active1");
        }

    heading[i].addEventListener("click",
        function() {
            this.classList.toggle("icon");
        });

    /* start if */    
    if(width < 481){
        heading[i].removeEventListener("click", accordion);
        heading[i].addEventListener("click",
        function() {
            var panel = this.nextElementSibling;
            panel.classList.toggle("active2");
        });
    }/* end if */    
}/* end for loop */