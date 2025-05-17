class PAWMenu {
	constructor(pContenedor) {
		//Conseguir Nodo NAV

		let contenedor = pContenedor.tagName
			? pContenedor
			: document.querySelector(pContenedor);
			console.log("Contenedor encontrado:", contenedor);

		if (contenedor) {
			contenedor.classList.add("PAW-Menu");
			contenedor.classList.add("PAW-MenuCerrado");

			let css = PAW.nuevoElemento("link", "", {
				rel: "stylesheet",
				href: "styles/pawmenu.css",
			});
			document.head.appendChild(css);

			// Armar Boton
			let boton = PAW.nuevoElemento("button", "", {
				class: "PAW-MenuAbrir",
			});

			console.log("Botón insertado:", boton);

			boton.addEventListener("click", (event) => {
				console.log("CLICK CAPTURADO");
				const btn = event.currentTarget;
				console.log("Clases actuales del botón:", btn.classList);
				if (btn.classList.contains("PAW-MenuAbrir")) {
						console.log("Abriendo menú");
					btn.classList.add("PAW-MenuCerrar");
					btn.classList.remove("PAW-MenuAbrir");
					contenedor.classList.add("PAW-MenuAbierto");
					contenedor.classList.remove("PAW-MenuCerrado");
				} else {
					console.log("Cerrando menú");
					btn.classList.add("PAW-MenuAbrir");
					btn.classList.remove("PAW-MenuCerrar");
					contenedor.classList.add("PAW-MenuCerrado");
					contenedor.classList.remove("PAW-MenuAbierto");
				}
			});


			// Insertar boton en el NAV
			contenedor.prepend(boton);
		} else {
			console.error("Elemento HTML para generar el MENU no encontrado");
		}
	}
}