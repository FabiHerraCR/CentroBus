document.addEventListener("DOMContentLoaded", () => {
    const rutaSelect = document.querySelector('select[name="ruta_id"]');
    const cantidadInput = document.querySelector('input[name="cantidad"]');
    const totalCompra = document.getElementById("total-compra");

    function actualizarTotalCompra() {
        const selectedOption = rutaSelect.options[rutaSelect.selectedIndex];
        const precio = Number(selectedOption.dataset.precio || 0);
        const cantidad = Number(cantidadInput.value || 0);
        const total = precio * cantidad;

        totalCompra.textContent = `$${total.toFixed(2)}`;
    }

    if (rutaSelect && cantidadInput && totalCompra) {
        rutaSelect.addEventListener("change", actualizarTotalCompra);
        cantidadInput.addEventListener("input", actualizarTotalCompra);

        actualizarTotalCompra();
    }

    const tarjetaInput = document.getElementById("tarjeta");
    const tipoTarjeta = document.getElementById("tipo-tarjeta");

    function detectarTipoTarjeta(numeroTarjeta) {
        const numero = numeroTarjeta.replace(/\D/g, "");

        if (numero === "") {
            return "";
        }

        if (/^4/.test(numero)) {
            return "Tipo de tarjeta: Visa";
        }

        if (/^3[47]/.test(numero)) {
            return "Tipo de tarjeta: American Express";
        }

        if (/^(5[1-5]|2[2-7])/.test(numero)) {
            return "Tipo de tarjeta: Mastercard";
        }

        return "Tipo de tarjeta: no reconocida";
    }

    if (tarjetaInput && tipoTarjeta) {
        const actualizarTipoTarjeta = () => {
            const textoTipoTarjeta = detectarTipoTarjeta(tarjetaInput.value);

            tipoTarjeta.textContent = textoTipoTarjeta;
            tipoTarjeta.classList.toggle("hidden", textoTipoTarjeta === "");
        };

        tarjetaInput.addEventListener("input", actualizarTipoTarjeta);

        actualizarTipoTarjeta();
    }

    const contactoForm = document.getElementById("contacto-form");
    const contactoEstado = document.getElementById("contacto-estado");

    if (contactoForm && contactoEstado) {
        contactoForm.addEventListener("submit", (event) => {
            event.preventDefault();
            contactoEstado.classList.remove("hidden");
        });

        contactoForm.querySelector("button")?.addEventListener("click", () => {
            contactoEstado.classList.remove("hidden");
        });
    }
});
