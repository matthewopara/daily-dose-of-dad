let destinations = document.querySelectorAll(".dest");
let url = location.protocol + '//' + location.host + location.pathname;

for (const dest of destinations) {
    if (dest.href == url) {
        dest.classList.add("active");
        dest.setAttribute("aria-curent", "page");
    } else {
        dest.classList.remove("active");
        dest.removeAttribute("aria-current");
    }
}
