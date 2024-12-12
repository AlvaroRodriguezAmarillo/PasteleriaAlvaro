let inactividad; 

function reiniciarTiempo() {
    clearTimeout(inactividad); 
    inactividad = setTimeout(() => {
        const respuestaUsuario = confirm("¿Sigues ahí? ¿Deseas continuar navegando?");
        if (!respuestaUsuario) {
            
            window.location.href = "index.php";
        }
    }, 10000); //10 segundos de inactividad
}

//Se escuchan eventos para detectar actividad del usuario
['mousemove', 'keydown', 'scroll', 'click'].forEach(evento => {
    window.addEventListener(evento, reiniciarTiempo);
});

//Iniciar el temporizador por primera vez
reiniciarTiempo();
