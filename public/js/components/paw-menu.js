class PAWMenu {
	constructor(pContenedor) {
		//Conseguir Nodo NAV

		let contenedor = pContenedor.tagName
			? pContenedor
			: document.querySelector(pContenedor);

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


			boton.addEventListener("click", (event) => {
				const btn = event.currentTarget;
				if (btn.classList.contains("PAW-MenuAbrir")) {
					btn.classList.add("PAW-MenuCerrar");
					btn.classList.remove("PAW-MenuAbrir");
					contenedor.classList.add("PAW-MenuAbierto");
					contenedor.classList.remove("PAW-MenuCerrado");
				} else {
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