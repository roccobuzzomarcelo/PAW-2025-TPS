class BuscarPorTitulo {
  /**
   * @param {Object} selectors
   * @param {string} selectors.form
   * @param {string} selectors.inputQuery
   * @param {string} selectors.titulo
   * @param {string} selectors.autor
   * @param {string} selectors.descripcion
   * @param {string} selectors.imagenInput
   * @param {string} selectors.preview
   */
    constructor({
        form = '#formSubirLibro',
        inputQuery = '#query',
        titulo = '#titulo',
        autor = '#autor',
        descripcion = '#descripcion',
        hiddenUrl = '#ruta_a_imagen_api',
        imagenInput = '#imagen',
        preview = '#preview',
        btnAutocompletar = '#btnAutocompletar'
    } = {}) {
        this.$form = document.querySelector(form);
        if (!this.$form) return; // Si no hay formulario, no hace nada

        this.$inputQuery = document.querySelector(inputQuery);
        this.$titulo = document.querySelector(titulo);
        this.$autor = document.querySelector(autor);
        this.$descripcion = document.querySelector(descripcion);
        this.$imagenInput = document.querySelector(imagenInput);
        this.$preview = document.querySelector(preview);
        this.$hiddenUrl   = document.querySelector(hiddenUrl);
        this.$btnAuto     = document.querySelector(btnAutocompletar);
        
        this._bindEvents();
    }

    _bindEvents() {
        if (this.$btnAuto) {
            this.$btnAuto.addEventListener('click', e => {
                e.preventDefault();
                this.buscar();
            });
        }

        if (this.$imagenInput) {
            this.$imagenInput.addEventListener('change', e => {
            const file = e.target.files[0];
            if (file) {
                const reader = new FileReader();
                reader.onload = () => {
                this.$preview.src = reader.result;
                this.$preview.style.display = 'block';
                this.$hiddenUrl.value = '';
                this.$hiddenUrl.dispatchEvent(new Event('change'));
                };
                reader.readAsDataURL(file);
            }
            });
        }
    }

    buscar() {
        const query = encodeURIComponent(this.$inputQuery.value.trim());
        if (!query) {
            alert('Ingresá un título válido.');
            return;
        }

        fetch(`https://openlibrary.org/search.json?title=${query}&limit=1`)
        .then(res => res.json())
        .then(data => this._llenarCampos(data))
        .catch(err => {
            console.error(err);
            alert('Error al consultar la API.');
        });
    }

    _llenarCampos(data) {
        const doc = data.docs && data.docs[0];
        if (!doc) {
            alert('No se encontraron datos para ese título.');
            return;
        }
        

        this.$titulo.value = doc.title || '';
        this.$autor.value = (doc.author_name && doc.author_name[0]) || '';

        // Imagen de portada
        if (doc.cover_i && this.$hiddenUrl) {
            const coverUrl = `https://covers.openlibrary.org/b/id/${doc.cover_i}-L.jpg`;
            this.$hiddenUrl.value = coverUrl;
            this.$hiddenUrl.dispatchEvent(new Event('change'));
            this.$preview.src = coverUrl;
            this.$preview.style.display = 'block';
            this.$imagenInput.value = '';
        }

        // Buscar descripción más completa usando el key del work
        if (doc.key) {
            fetch(`https://openlibrary.org${doc.key}.json`)
            .then(res => res.json())
            .then(workData => {
                let descripcion = 'Sin descripción';
                if (workData.description) {
                if (typeof workData.description === 'string') {
                    descripcion = workData.description;
                } else if (typeof workData.description === 'object' && workData.description.value) {
                    descripcion = workData.description.value;
                }
                }
                this.$descripcion.value = descripcion;
            })
            .catch(err => {
                console.warn('No se pudo obtener la descripción detallada:', err);
                this.$descripcion.value = '';
            });
        } else {
            this.$descripcion.value = '';
        }
        }


}
