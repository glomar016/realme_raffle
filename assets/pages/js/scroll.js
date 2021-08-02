function parallax(element, distance, speed){
const item = document.querySelector(element);

item.style.transform = `translateY(${distance * speed}px)`;
}

window.addEventListener('scroll', function(){
    parallax('.body', window.scrollY, 1)
    parallax('.web-banner', window.scrollY, 0.5)
})