const slider = document.getElementById('slider');
let index = 0;

function moveSlider() {
    index++;
    if (index >= slider.children.length) {
        index = 0;
    }
    slider.style.transform = `translateX(-${index * 100}%)`;
}

// Move the slider every 2 seconds
setInterval(moveSlider, 2000);
