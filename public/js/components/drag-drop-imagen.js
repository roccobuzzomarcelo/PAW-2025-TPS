class DragAndDropImagen {
	constructor(dropzoneSelector, inputSelector, previewSelector) {
		this.dropzone = document.querySelector(dropzoneSelector);
		this.fileInput = document.querySelector(inputSelector);
		this.preview = document.querySelector(previewSelector);

		if (this.dropzone && this.fileInput && this.preview) {
			this.init();
		}
	}

	init() {
		this.dropzone.addEventListener("dragover", (e) => {
			e.preventDefault();
			this.dropzone.classList.add("dragover");
		});

		this.dropzone.addEventListener("dragleave", () => {
			this.dropzone.classList.remove("dragover");
		});

		this.dropzone.addEventListener("drop", (e) => {
			e.preventDefault();
			this.dropzone.classList.remove("dragover");

			const file = e.dataTransfer.files[0];
			if (file && file.type.startsWith("image/")) {
				this.fileInput.files = e.dataTransfer.files;
				this.mostrarVistaPrevia(file);
			} else {
				alert("Por favor soltá una imagen válida.");
			}
		});

		this.dropzone.addEventListener("click", () => {
			this.fileInput.click();
		});

		this.fileInput.addEventListener("change", () => {
			if (this.fileInput.files.length > 0) {
				const file = this.fileInput.files[0];
				if (file.type.startsWith("image/")) {
					this.mostrarVistaPrevia(file);
				}
			}
		});
	}

	mostrarVistaPrevia(file) {
		const reader = new FileReader();
		reader.onload = (e) => {
			this.preview.src = e.target.result;
			this.preview.style.display = "block";
		};
		reader.readAsDataURL(file);
	}
}
