class FiltrosLibros {
	constructor() {
		this.btnAplicar = document.getElementById('btnAplicarFiltro');
		this.precioMinInput = document.getElementById('precioMin');
		this.precioMaxInput = document.getElementById('precioMax');
		this.ordenarSelect = document.getElementById('ordenarPor');
		this.contenedorLibros = document.querySelector('.cont-libros');
		this.filtrosLibros = document.getElementById('filtrosLibros');

		if (!this.btnAplicar || !this.ordenarSelect || !this.contenedorLibros || !this.filtrosLibros) return;

		this.librosOriginales = Array.from(this.contenedorLibros.children);


		this.btnAplicar.addEventListener('click', () => this.filtrarYOrdenarLibros());
		this.ordenarSelect.addEventListener('change', () => this.filtrarYOrdenarLibros());

		let css = PAW.nuevoElemento("link", "", {
			rel: "stylesheet",
			href: "styles/filtroLibro.css",
		});
		document.head.appendChild(css);
	}

	extraerPrecio(libro) {
		const precioText = libro.querySelector('p')?.textContent.replace('$', '').replace('.', '').replace(',', '.').trim();
		return parseFloat(precioText) || 0;
	}

	filtrarYOrdenarLibros() {
		const min = parseFloat(this.precioMinInput.value) || 0;
		const max = parseFloat(this.precioMaxInput.value) || Infinity;
		const criterio = this.ordenarSelect.value;

		let librosFiltrados = this.librosOriginales.filter(libro => {
			const precio = this.extraerPrecio(libro);
			return precio >= min && precio <= max;
		});

		// Mostrar u ocultar filtros según haya o no resultados
		if (librosFiltrados.length > 0) {
			this.filtrosLibros.style.display = "block";
		} else {
			this.filtrosLibros.style.display = "none";
		}

		librosFiltrados.sort((a, b) => {
			const getText = (el, sel) => el.querySelector(sel)?.textContent.trim().toLowerCase() || '';

			switch (criterio) {
				case 'titulo-asc':
					return getText(a, 'h3').localeCompare(getText(b, 'h3'));
				case 'titulo-desc':
					return getText(b, 'h3').localeCompare(getText(a, 'h3'));
				case 'autor-asc':
					return getText(a, '.autor').localeCompare(getText(b, '.autor'));
				case 'autor-desc':
					return getText(b, '.autor').localeCompare(getText(a, '.autor'));
				case 'precio-asc':
					return this.extraerPrecio(a) - this.extraerPrecio(b);
				case 'precio-desc':
					return this.extraerPrecio(b) - this.extraerPrecio(a);
				default:
					return 0;
			}
		});

		this.contenedorLibros.innerHTML = '';
		librosFiltrados.forEach(libro => this.contenedorLibros.appendChild(libro));
	}
}
