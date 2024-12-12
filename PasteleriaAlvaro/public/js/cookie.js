let inactividad; // Variable para rastrear el temporizador de inactividad

function reiniciarTiempo() {
    clearTimeout(inactividad); // Limpiar el temporizador actual
    inactividad = setTimeout(() => {
        const respuestaUsuario = confirm("¿Sigues ahí? ¿Deseas continuar navegando?");
        if (!respuestaUsuario) {
            // Redirigir al formulario inicial
            window.location.href = "index.php";
        }
    }, 10000); // 10 segundos de inactividad
}

// Escuchar eventos para detectar actividad del usuario
['mousemove', 'keydown', 'scroll', 'click'].forEach(evento => {
    window.addEventListener(evento, reiniciarTiempo);
});

// Iniciar el temporizador por primera vez
reiniciarTiempo();
