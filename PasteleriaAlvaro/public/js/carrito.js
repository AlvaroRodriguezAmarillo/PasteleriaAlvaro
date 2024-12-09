// Función para confirmar si el usuario quiere pagar
function confirmarPago() {
    let confirmacion = confirm("¿Estás seguro de que quieres pagar?");
    if (confirmacion) {
        alert("¡Gracias por su compra en la pastelería!");
        // Aquí podrías realizar la lógica para finalizar la compra
        window.location.href = 'gracias.php'; // Página de agradecimiento
    }
}

// Función para cancelar la compra y volver al carrito
function cancelarCompra() {
    window.location.href = 'carrito.php'; // Volver al carrito
}
