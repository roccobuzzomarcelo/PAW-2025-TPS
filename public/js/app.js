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

			PAW.cargarScript("ValidacionLibro", "js/components/validacion-libro.js", () => {
				new ValidacionLibro('#formSubirLibro');
			});

			PAW.cargarScript("DragDropImagen", "js/components/drag-drop-imagen.js", () => {
				new DragAndDropImagen("#dropzone", "#imagen", "#preview");
			});

			PAW.cargarScript("FiltrosLibros", "js/components/filtro-libros.js", () => {
				new FiltrosLibros();
			});

			PAW.cargarScript("HistorialBusquedas", "js/components/historial-busquedas.js", () => {
				new HistorialBusquedas('ultimasBusquedas', 5);
			});
		});
	}
}

let app = new appPAW();


