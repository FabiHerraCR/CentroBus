document.addEventListener("DOMContentLoaded", () => {
    const rutaSelect = document.querySelector('select[name="ruta_id"]');
    const cantidadInput = document.querySelector('input[name="cantidad"]');
    const totalCompra = document.getElementById("total-compra");

    if (!rutaSelect || !cantidadInput || !totalCompra) {
        return;
    }

    function actualizarTotal() {
        const selectedOption = rutaSelect.options[rutaSelect.selectedIndex];
        const precio = Number(selectedOption.dataset.precio || 0);
        const cantidad = Number(cantidadInput.value || 0);
        const total = precio * cantidad;

        totalCompra.textContent = `$${total.toFixed(2)}`;
    }

    rutaSelect.addEventListener("change", actualizarTotal);
    cantidadInput.addEventListener("input", actualizarTotal);

    actualizarTotal();
});
