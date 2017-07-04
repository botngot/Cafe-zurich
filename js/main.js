console.log("%cvinathinh.com / AAK.works",'color: #1a237e; font-size: 32px; font-family: "Arial"; font-weight: bold; text-transform: uppercase;');

//NAV

var toggle = document.querySelector('.toggle');

toggle.addEventListener('click', function() {
    document.body.classList.toggle("is-opened");
});

$(document).ready(function(){
	$('.carousel').slick({
		infinite: true,
		slidesToShow: 3,
		centerMode: true,
		appendArrows: $(".slider__arrows"), // Class For Arrows Buttons
		prevArrow: '<div class="arrow-left"></div>',
		nextArrow: '<div class="arrow-right"></div>', 
		variableWidth: true
	});


	var userFeed = new Instafeed({
		get: 'user',
		userId: "1647333865",
		resolution: "standard_resolution",
		limit: 24,
		// get: 'tagged',
  //       tagName: 'awesome',
		clientId: "59762d6276534c2fbf177099ec5043cc",
		accessToken: "229580817.ba4c844.cd0f63faef444a86a66ffd5d008a4fb9",
		template: '<div style="background-image: url({{image}});"class="instafeed__block"></div>',
		after: function() {
			$('#instafeed').slick({
				slidesToShow: 3,
				centerMode: false,
				appendArrows: $(".slider__arrows--insta"), // Class For Arrows Buttons
				prevArrow: '<span class="arrow-left"></span>',
				nextArrow: '<span class="arrow-right"></span>',
				infinite: false,
				variableWidth: true
			});
		}
	});
	userFeed.run();
});

document.querySelector(".nav__overons").onclick = function() {
	document.body.classList.remove("is-opened");
    var tar = document.querySelector(".intro");

    smoothScroll(tar, 300);
};

document.querySelector(".nav__menu").onclick = function() {
	document.body.classList.remove("is-opened");
    var tar = document.querySelector(".menukaarten");
    smoothScroll(tar, 500);
};

document.querySelector(".nav__ambiance").onclick = function() {
	document.body.classList.remove("is-opened");
    var tar = document.querySelector(".ambiance");
    smoothScroll(tar, 500);
};

document.querySelector(".nav__nieuws").onclick = function() {
	document.body.classList.remove("is-opened");
    var tar = document.querySelector(".nieuws");
    smoothScroll(tar, 500);
};

document.querySelector(".nav__reserveren").onclick = function() {
	document.body.classList.remove("is-opened");
    var tar = document.querySelector(".reserveren");
    smoothScroll(tar, 500);
};

document.querySelector(".nav__contact").onclick = function() {
	document.body.classList.remove("is-opened");
    var tar = document.querySelector(".contact");
    smoothScroll(tar, 500);
};

function getTop(element, start) {
    if(element.nodeName === 'HTML') return -start
    return element.getBoundingClientRect().top + start
}
function animation(t) { return t<.5 ? 4*t*t*t : (t-1)*(2*t-2)*(2*t-2)+1 }

function position(start, end, elapsed, duration) {
    if (elapsed > duration) return end;
    return start + (end - start) * animation(elapsed / duration);
}

function smoothScroll(el, duration){
    var start = window.pageYOffset,
        end = getTop(el, start),
        clock = Date.now();

    var requestAnimationFrame = window.requestAnimationFrame ||
        window.mozRequestAnimationFrame || window.webkitRequestAnimationFrame ||
        function(fn){window.setTimeout(fn, 15);};

    var step = function(){
        var elapsed = Date.now() - clock;
        window.scroll(0, position(start, end, elapsed, duration));

        if (elapsed > duration) {
            if (typeof callback === 'function') {
                callback(el);
            }
        } else {
            requestAnimationFrame(step);
        }
    }
    step();
}

$(document).on('resize', function(){
	$('.photo-grid').packery({
		itemSelector: '.single-photo',
		gutter: 20
	});
});

$(document).ready(function(){
	$(document).resize();
})





