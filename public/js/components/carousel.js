class Carousel {
	constructor(pContenedor) {

		let contenedor = pContenedor.tagName
			? pContenedor
			: document.querySelector(pContenedor);

		if (!contenedor) {
			console.error("Contenedor del Carousel no encontrado");
			return;
		}

		contenedor.classList.add("carousel");

		let css = PAW.nuevoElemento("link", "", {
			rel: "stylesheet",
			href: "styles/carousel.css",
		});
		document.head.appendChild(css);

		const imagenes = contenedor.querySelectorAll("img");
		const total = imagenes.length;
		let cargadas = 0;
		let indiceActual = 0;

		const progreso = PAW.nuevoElemento("div", "", { class: "carousel-progress" });
		contenedor.appendChild(progreso);

		imagenes.forEach((img) => {
      if (img.complete) {
        cargadas++;
        progreso.style.width = `${(cargadas / total) * 100}%`;
        if (cargadas === total) {
            setTimeout(() => {
            progreso.remove();
            inicializarCarousel();
          }, 300);
        }
      } else {
        img.onload = () => {
          cargadas++;
          progreso.style.width = `${(cargadas / total) * 100}%`;

          if (cargadas === total) {
            setTimeout(() => {
              progreso.remove();
              inicializarCarousel();
            }, 300);
          }
        };
        img.onerror = () => {
          cargadas++;
        };
      }
    });

		function inicializarCarousel() {
			console.log("🔧 Inicializando estructura del carousel");
			const wrapper = PAW.nuevoElemento("div", "", { class: "carousel-wrapper" });
			const navPrev = PAW.nuevoElemento("button", "⟨", { class: "carousel-button-prev" });
			const navNext = PAW.nuevoElemento("button", "⟩", { class: "carousel-button-next" });
			const thumbs = PAW.nuevoElemento("div", "", { class: "carousel-thumbs" });

			imagenes.forEach((img, i) => {
				const slide = PAW.nuevoElemento("div", "", { class: "carousel-slide" });
				slide.appendChild(img);
				wrapper.appendChild(slide);

				const thumb = PAW.nuevoElemento("img", "", {
					src: img.src,
					class: "carousel-thumb",
				});
				thumb.addEventListener("click", () => mostrarSlide(i));
				thumbs.appendChild(thumb);
			});

			contenedor.appendChild(wrapper);
			const buttonsContainer = PAW.nuevoElemento("div", "", { class: "carousel-buttons" });
			buttonsContainer.appendChild(navPrev);
			buttonsContainer.appendChild(navNext);
			contenedor.appendChild(buttonsContainer);
			contenedor.appendChild(thumbs);

			mostrarSlide(indiceActual);

			navNext.addEventListener("click", () => avanzar(1));
			navPrev.addEventListener("click", () => avanzar(-1));

			document.addEventListener("keydown", (e) => {
				if (e.key === "ArrowRight") avanzar(1);
				if (e.key === "ArrowLeft") avanzar(-1);
			});

			let startX = 0;
			wrapper.addEventListener("touchstart", (e) => {
				startX = e.touches[0].clientX;
			});
			wrapper.addEventListener("touchend", (e) => {
				let endX = e.changedTouches[0].clientX;
				if (startX - endX > 50) avanzar(1);
				else if (endX - startX > 50) avanzar(-1);
			});

			setInterval(() => avanzar(1), 5000);
		}

		function mostrarSlide(i) {
			const slides = contenedor.querySelectorAll(".carousel-slide");
			const thumbs = contenedor.querySelectorAll(".carousel-thumb");
			slides.forEach((s, idx) =>
				s.classList.toggle("active", idx === i)
			);
			thumbs.forEach((t, idx) =>
				t.classList.toggle("active", idx === i)
			);
			indiceActual = i;
		}

		function avanzar(delta) {
			let nuevoIndice = (indiceActual + delta + total) % total;
			mostrarSlide(nuevoIndice);
		}
	}
}
