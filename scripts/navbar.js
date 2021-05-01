let destinations = document.querySelectorAll(".dest");
let url = window.location.href;

for (const dest of destinations) {
    if (dest.href == url) {
        dest.classList.add("active");
        dest.setAttribute("aria-curent", "page");
    } else {
        dest.classList.remove("active");
        dest.removeAttribute("aria-current");
    }
}
