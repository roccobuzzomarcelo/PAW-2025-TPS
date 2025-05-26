class HistorialBusquedas {
    constructor(storageKey = 'ultimasBusquedas', maxBusquedas = 5) {
        this.storageKey = storageKey;
        this.maxBusquedas = maxBusquedas;
        this.input = document.getElementById('buscador-de-libros');
        this.form = document.querySelector('form.buscador');
        this.listaHistorial = document.getElementById('historialBusquedas');

        let css = PAW.nuevoElemento("link", "", {
            rel: "stylesheet",
            href: "styles/historial-libro.css",
        });
        document.head.appendChild(css);

        if (this.input && this.form && this.listaHistorial) {
            this.init();
        }
        this.ocultar();
    }

    init() {
        this.form.addEventListener('submit', () => {
            const valor = this.input.value.trim();
            if (valor) {
                this.guardar(valor);
            }
        });

        this.input.addEventListener('focus', () => {
            if (this.obtener().length > 0) {
                this.mostrar();
            }
        });

        this.input.addEventListener('blur', () => {
            // Usamos un pequeño delay para permitir clics en el historial
            setTimeout(() => this.ocultar(), 150);
        });

        this.input.addEventListener('input', () => {
            if (this.input.value.trim() === '') {
                if (this.obtener().length > 0) {
                    this.mostrar();
                }
            } else {
                this.ocultar();
            }
        });

        this.renderizar();
    }

    guardar(busqueda) {
        let busquedas = JSON.parse(localStorage.getItem(this.storageKey)) || [];

        busquedas = busquedas.filter(b => b !== busqueda);
        busquedas.unshift(busqueda);

        if (busquedas.length > this.maxBusquedas) {
            busquedas.pop();
        }

        localStorage.setItem(this.storageKey, JSON.stringify(busquedas));
        this.renderizar();
    }

    obtener() {
        return JSON.parse(localStorage.getItem(this.storageKey)) || [];
    }

    renderizar() {
        const busquedas = this.obtener();
        this.listaHistorial.innerHTML = '';

        if (busquedas.length === 0) {
            this.ocultar();
            return;
        }

        busquedas.forEach(busqueda => {
            const li = document.createElement('li');
            li.textContent = busqueda;
            li.classList.add('busqueda-item');
            li.style.cursor = 'pointer';
            li.addEventListener('click', () => {
                this.input.value = busqueda;
                this.form.submit();
            });
            this.listaHistorial.appendChild(li);
        });
    }

    ocultar() {
        this.listaHistorial.classList.add('oculto');
    }

    mostrar() {
        this.listaHistorial.classList.remove('oculto');
    }
}
