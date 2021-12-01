//active nav button when scroll

const sections = document.querySelectorAll('section');
const navLi = document.querySelector('li');

window.addEventListener("scroll", () => {
    let current = "";
    sections.forEach((section) => {
      const sectionTop = section.offsetTop;
      const sectionHeight = section.clientHeight;
      if (pageYOffset >= sectionTop - sectionHeight / 3) {
        current = section.getAttribute("id");
      }
    });
  
    navLi.foreach((li) => {
      li.classList.remove("abc");
      if (li.classList.contains(current)) {
        li.classList.add("abc");
      }
    });
  });