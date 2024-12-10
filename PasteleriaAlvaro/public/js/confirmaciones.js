document.addEventListener("DOMContentLoaded", () => {
    const guardarBotones = document.querySelectorAll(".confirmar-guardar");
    const eliminarBotones = document.querySelectorAll(".confirmar-eliminar");

    guardarBotones.forEach(boton => {
        boton.addEventListener("click", event => {
            if (!confirm("¿Estás seguro de que deseas guardar los cambios?")) {
                event.preventDefault();
            }
        });
    });

    eliminarBotones.forEach(boton => {
        boton.addEventListener("click", event => {
            if (!confirm("¿Estás seguro de que deseas eliminar este producto?")) {
                event.preventDefault();
            }
        });
    });
});
