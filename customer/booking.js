//for slider manual play

var btns = document.querySelectorAll(".swap-btn");
var slides = document.querySelectorAll(".img-slide");
var contents = document.querySelectorAll(".content");

var sliderNav = function(manual){
    btns.forEach((btn)=>{
        btn.classList.remove("active");
    });

    slides.forEach((slide)=>{
        slide.classList.remove("active");
    });

    contents.forEach((content)=>{
        content.classList.remove("active");
    });

    btns[manual].classList.add("active");
    slides[manual].classList.add("active");
    contents[manual].classList.add("active");
}

btns.forEach((btn,i)=>{
    btn.addEventListener("click",()=>{
        sliderNav(i);
    });
});


// for slide auto play

var repeat = function(activeClass){
    let active = document.getElementsByClassName("active");
    let i = 1;

    var repeater =() =>{
        setTimeout(function(){

            [...active].forEach((activeSlide) =>{
                activeSlide.classList.remove("active");
            });

            slides[i].classList.add("active");
            btns[i].classList.add("active");
            contents[i].classList.add("active");
            i++;

            if(slides.length == i){
                i = 0;
            }

            if(i >= slides.length){
                return;
            }

            repeater();
        },5000);
    }
    repeater();

}
repeat();