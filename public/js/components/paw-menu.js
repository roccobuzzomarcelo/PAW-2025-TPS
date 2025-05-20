class PAWMenu {
	constructor(pContenedor) {
		// Conseguir un nodo de tipo <nav>
		let contenedor = pContenedor.tagName
			? pContenedor
			: document.querySelector(pContenedor);

		// Si existe el contenedor, entonces le agrega la clase "PAW-Menu" al contenedor.
		if (contenedor) {
			contenedor.classList.add("PAW-Menu");
			contenedor.classList.add("PAW-MenuCerrado");

			// Insertamos el css del menu en la página
			let css = PAW.nuevoElemento("link", "", {
				rel: "stylesheet",
				href: "styles/pawmenu.css",
			});
			document.head.appendChild(css);

			// Armar un BOTON que tenga la funcionalidad de hamburguesa
			let boton = PAW.nuevoElemento("button", "", {
				class: "PAW-MenuAbrir",
			});
			
			// Agregamos la funcionalidad de abrir o de cerrar al boton.
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