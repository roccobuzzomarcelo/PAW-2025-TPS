class appPAW {
	constructor() {
		document.addEventListener("DOMContentLoaded", () => {
			PAW.cargarScript("PAW-Menu", "js/components/paw-menu.js", () => {
				let menu = new PAWMenu(".nav-bar");
			});

			PAW.cargarScript("Carousel", "js/components/carousel.js", () => {
				const esperarContenedor = () => {
					let c = document.querySelector(".carousel-container");
					if (c) {
						new Carousel(".carousel-container");
					} else {
						setTimeout(esperarContenedor, 100);
					}
				};
				esperarContenedor();
			});
		});
	}
}

let app = new appPAW();


