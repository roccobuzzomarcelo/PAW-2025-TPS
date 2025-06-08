class ValidacionLibro {
    constructor(formSelector = '#formSubirLibro') {
        this.form = document.querySelector(formSelector);
        if (!this.form) return;

        this.submitBtn = this.form.querySelector('input[type="submit"]');

        let css = PAW.nuevoElemento("link", "", {
            rel: "stylesheet",
            href: "styles/error-message.css",
        });
        document.head.appendChild(css);

        const hiddenUrl = this.form.querySelector('#ruta_a_imagen_api');


        this.campos = {
            titulo: {
                input: this.form.titulo,
                error: this.form.querySelector('#error-titulo'),
                validar: function () {
                    if (this.input.value.trim() === '') {
                        this.error.textContent = 'El título es obligatorio.';
                        this.input.classList.add('invalid');
                        return false;
                    }
                    this.error.textContent = '';
                    this.input.classList.remove('invalid');
                    return true;
                }
            },
            autor: {
                input: this.form.autor,
                error: this.form.querySelector('#error-autor'),
                validar: function () {
                    if (this.input.value.trim() === '') {
                        this.error.textContent = 'El autor es obligatorio.';
                        this.input.classList.add('invalid');
                        return false;
                    }
                    this.error.textContent = '';
                    this.input.classList.remove('invalid');
                    return true;
                }
            },
            descripcion: {
                input: this.form.descripcion,
                error: this.form.querySelector('#error-descripcion'),
                validar: function () {
                    if (this.input.value.trim() === '') {
                        this.error.textContent = 'La descripción es obligatoria.';
                        this.input.classList.add('invalid');
                        return false;
                    }
                    this.error.textContent = '';
                    this.input.classList.remove('invalid');
                    return true;
                }
            },
            precio: {
                input: this.form.precio,
                error: this.form.querySelector('#error-precio'),
                validar: function () {
                    const val = this.input.value.trim();
                    if (val === '') {
                        this.error.textContent = 'El precio es obligatorio.';
                        this.input.classList.add('invalid');
                        return false;
                    }
                    const num = parseFloat(val);
                    if (isNaN(num) || num < 0) {
                        this.error.textContent = 'El precio debe ser un número mayor o igual a 0.';
                        this.input.classList.add('invalid');
                        return false;
                    }
                    this.error.textContent = '';
                    this.input.classList.remove('invalid');
                    return true;
                }
            },
                  imagen: {
                    input: this.form.querySelector('#imagen'),
                    hiddenUrl: hiddenUrl,
                    error: this.form.querySelector('#error-imagen'),
                    validar: function() {
                    const hasFile = this.input.files.length > 0;
                    const hasUrl  = this.hiddenUrl && this.hiddenUrl.value.trim() !== '';
                    if (!hasFile && !hasUrl) {
                        this.error.textContent = 'Debe subir un archivo o usar la portada de la API.';
                        this.input.classList.add('invalid');
                        return false;
                    }
                    if (hasFile) {
                        const f = this.input.files[0];
                        const tipos = ['image/jpeg','image/png','image/gif','image/webp'];
                        if (!tipos.includes(f.type)) {
                        this.error.textContent = 'Formato no válido. Use JPG/PNG/GIF/WEBP.';
                        this.input.classList.add('invalid');
                        return false;
                        }
                        if (f.size > 5*1024*1024) {
                        this.error.textContent = 'La imagen no debe superar los 5 MB.';
                        this.input.classList.add('invalid');
                        return false;
                        }
                    }
                    this.error.textContent = '';
                    this.input.classList.remove('invalid');
                    return true;
                    }
            }
        };

        this._agregarListeners();
        this._validarTodo(); // Validar al inicio para setear submit
    }

    _agregarListeners() {
        Object.values(this.campos).forEach(campo => {
            campo.input.addEventListener('input', () => {
                campo.validar();
                this._validarTodo();
            });

            // Para input file también validar en 'change'
            if (campo.input.type === 'file') {
                campo.input.addEventListener('change', () => {
                    campo.validar();
                    this._validarTodo();
                });
            }

            campo.input.addEventListener('blur', () => {
                campo.validar();
                this._validarTodo();
            });
        });

        const hiddenUrl = this.form.querySelector('#ruta_a_imagen_api');
        if (hiddenUrl) hiddenUrl.addEventListener('change', () => { this.campos.imagen.validar(); this._validarTodo(); });

        this.form.addEventListener('submit', e => {
            let todoValido = true;
            Object.values(this.campos).forEach(campo => {
                if (!campo.validar()) {
                    todoValido = false;
                }
            });
            if (!todoValido) {
                e.preventDefault();
            }
        });
    }

    _validarTodo() {
        const todosValidos = Object.values(this.campos).every(campo => campo.validar());
        this.submitBtn.disabled = !todosValidos;
    }
}