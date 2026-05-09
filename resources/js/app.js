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

    function formatearNumeroTarjeta(numeroTarjeta) {
        return numeroTarjeta
            .replace(/\D/g, "")
            .slice(0, 19)
            .replace(/(.{4})/g, "$1 ")
            .trim();
    }

    function detectarTipoTarjeta(numeroTarjeta) {
        const numero = numeroTarjeta.replace(/\D/g, "");

        if (numero === "") {
            return { texto: "", estado: "" };
        }

        if (/^4/.test(numero) && [13, 16, 19].includes(numero.length)) {
            return { texto: "Tipo de tarjeta: Visa", estado: "ok" };
        }

        if (/^3[47]\d{13}$/.test(numero)) {
            return { texto: "Tipo de tarjeta: American Express", estado: "ok" };
        }

        const primerosDos = Number(numero.slice(0, 2));
        const primerosCuatro = Number(numero.slice(0, 4));
        const esMastercard =
            numero.length === 16 &&
            ((primerosDos >= 51 && primerosDos <= 55) ||
                (primerosCuatro >= 2221 && primerosCuatro <= 2720));

        if (esMastercard) {
            return { texto: "Tipo de tarjeta: Mastercard", estado: "ok" };
        }

        if (numero.length < 13) {
            return { texto: "Complete el número de tarjeta", estado: "pendiente" };
        }

        return { texto: "Tipo de tarjeta: no reconocida", estado: "error" };
    }

    if (tarjetaInput && tipoTarjeta) {
        const actualizarTipoTarjeta = () => {
            tarjetaInput.value = formatearNumeroTarjeta(tarjetaInput.value);

            const tipoDetectado = detectarTipoTarjeta(tarjetaInput.value);

            tipoTarjeta.textContent = tipoDetectado.texto;
            tipoTarjeta.classList.toggle("hidden", tipoDetectado.texto === "");
            tipoTarjeta.classList.toggle("text-emerald-400", tipoDetectado.estado === "ok");
            tipoTarjeta.classList.toggle("text-amber-300", tipoDetectado.estado === "pendiente");
            tipoTarjeta.classList.toggle("text-red-300", tipoDetectado.estado === "error");
        };

        tarjetaInput.addEventListener("input", actualizarTipoTarjeta);

        actualizarTipoTarjeta();
    }

    const fechaVencimientoInput = document.getElementById("fecha-vencimiento");

    function formatearFechaVencimiento(fechaVencimiento) {
        const numero = fechaVencimiento.replace(/\D/g, "").slice(0, 4);

        if (numero.length <= 2) {
            return numero;
        }

        return `${numero.slice(0, 2)}/${numero.slice(2)}`;
    }

    if (fechaVencimientoInput) {
        fechaVencimientoInput.addEventListener("input", () => {
            fechaVencimientoInput.value = formatearFechaVencimiento(fechaVencimientoInput.value);
        });

        fechaVencimientoInput.value = formatearFechaVencimiento(fechaVencimientoInput.value);
    }

    const telefonoInput = document.getElementById("telefono");

    function formatearTelefono(telefono) {
        const numero = telefono.replace(/\D/g, "").slice(0, 8);

        if (numero.length <= 4) {
            return numero;
        }

        return `${numero.slice(0, 4)}-${numero.slice(4)}`;
    }

    if (telefonoInput) {
        telefonoInput.addEventListener("input", () => {
            telefonoInput.value = formatearTelefono(telefonoInput.value);
        });

        telefonoInput.value = formatearTelefono(telefonoInput.value);
    }

    const ccvInput = document.getElementById("ccv");

    if (ccvInput) {
        ccvInput.addEventListener("input", () => {
            ccvInput.value = ccvInput.value.replace(/\D/g, "").slice(0, 4);
        });

        ccvInput.value = ccvInput.value.replace(/\D/g, "").slice(0, 4);
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
