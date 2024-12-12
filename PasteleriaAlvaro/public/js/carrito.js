//Función para confirmar si el usuario quiere pagar
function confirmarPago() {
    let confirmacion = confirm("¿Estás seguro de que quieres pagar?");
    if (confirmacion) {
        alert("¡Gracias por su compra en la pastelería!");
        window.location.href = 'gracias.php'; 
    }
}

//Función para cancelar la compra y volver al carrito
function cancelarCompra() {
    window.location.href = 'carrito.php'; 
}
