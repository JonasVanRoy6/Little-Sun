document.getElementById("menu-toggle").addEventListener("change", function () {
    var menu = document.querySelector('.menu');
    if (this.checked) {
         menu.classList.add('show');
    } else {
         menu.classList.remove('show');
    }
});


