(function ($) {

	if ($(".testimonial-slider").length) {
		const swiper_testimonial = new Swiper(".testimonial-slider", {
			spaceBetween: 30,
			slidesPerView: 1,
			centeredSlides: true,
			loopedSlides: 5,
			loop: true,
			pagination: {
				el: ".swiper-pagination-progressbar",
				clickable: true,
				type: "progressbar",
			},
			navigation: {
				nextEl: ".testimonial-arrow-right",
				prevEl: ".testimonial-arrow-left",
			},
			breakpoints: {
				768: {
					spaceBetween: 100,
				},
			},
		});
	}

})(jQuery);


var maxValue = 100;

// Get all the "wrapper" elements
var wrappers = document.querySelectorAll('.wrapper');

wrappers.forEach(function (wrapper) {
	var svgCircle = wrapper.querySelector(".foreground-circle svg circle:not(.below)");
	var numberInsideCircle = wrapper.querySelector("#number-inside-circle");

	// Get the stroke-dasharray value from CSS
	var svgStrokeDashArray = parseInt(
		window
			.getComputedStyle(svgCircle)
			.getPropertyValue("stroke-dasharray")
			.replace("px", "")
	);

	// To animate the circle from the previous value
	var previousStrokeDashOffset = svgStrokeDashArray;

	// To animate the number from the previous value
	var previousValue = 0;

	var animationDuration = 1000;

	// Call this method and pass any value to start the animation
	// The 'value' should be in between 0 to maxValue
	function animateCircle(value) {
		var offsetValue = Math.floor(
			((maxValue - value) * svgStrokeDashArray) / maxValue
		);

		// This is to animate the circle
		svgCircle.animate(
			[
				// initial value
				{
					strokeDashoffset: previousStrokeDashOffset,
				},
				// final value
				{
					strokeDashoffset: offsetValue,
				},
			],
			{
				duration: animationDuration,
			}
		);

		// Without this, the circle gets filled 100% after the animation
		svgCircle.style.strokeDashoffset = offsetValue;

		// This is to animate the number.
		// If the current value and previous values are the same,
		// no need to do anything. Check the condition.
		if (value !== previousValue) {
			var speed;
			if (value > previousValue) {
				speed = animationDuration / (value - previousValue);
			} else {
				speed = animationDuration / (previousValue - value);
			}

			// Start the animation from the previous value
			var counter = previousValue;

			var intervalId = setInterval(() => {
				if (counter === value || counter === -1) {
					// End of the animation

					clearInterval(intervalId);

					// Save the current values
					previousStrokeDashOffset = offsetValue;
					previousValue = value;
				} else {
					if (value > previousValue) {
						counter += 1;
					} else {
						counter -= 1;
					}

					numberInsideCircle.innerHTML = counter + " %";
				}
			}, speed);
		}
	}

	// Animate with the data value when the page loads first time
	var dataValue = parseInt(wrapper.getAttribute("data-value"), 10);

	if (!isNaN(dataValue) && dataValue >= 0 && dataValue <= maxValue) {
		animateCircle(dataValue);
	} else {
		console.log("Invalid data value provided.");
	}
});

