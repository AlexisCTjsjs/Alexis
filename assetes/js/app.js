function calcularTriangulo() {
    const baseInput = document.getElementById('txtBase');
    const alturaInput = document.getElementById('txtAltura');
    const lado1Input = document.getElementById('txtLado1');
    const lado2Input = document.getElementById('txtLado2');
    const lado3Input = document.getElementById('txtLado3');
    const areaInput = document.getElementById('txtA');
    const perimetroInput = document.getElementById('txtP');

    if (!baseInput || !alturaInput || !lado1Input || !lado2Input || !lado3Input || !areaInput || !perimetroInput) {
        return false;
    }

    const base = parseFloat(baseInput.value);
    const altura = parseFloat(alturaInput.value);
    let lado1 = parseFloat(lado1Input.value);
    let lado2 = parseFloat(lado2Input.value);
    let lado3 = parseFloat(lado3Input.value);

    // Si lado1 está vacío pero base tiene valor válido, sincronizar lado1 con base
    if ((isNaN(lado1) || lado1 <= 0) && (!isNaN(base) && base > 0)) {
        lado1Input.value = base;
        lado1 = base;
    }

    let calculoRealizado = false;

    // Cálculo del Área: (base * altura) / 2
    if (!isNaN(base) && base > 0 && !isNaN(altura) && altura > 0) {
        const area = (base * altura) / 2;
        areaInput.value = area.toFixed(2);
        calculoRealizado = true;
    } else {
        areaInput.value = '';
    }

    // El perímetro solo corresponde a un triángulo si se cumple la desigualdad triangular.
    const ladosPositivos = lado1 > 0 && lado2 > 0 && lado3 > 0;
    const trianguloValido = ladosPositivos &&
        lado1 + lado2 > lado3 &&
        lado1 + lado3 > lado2 &&
        lado2 + lado3 > lado1;

    if (trianguloValido) {
        const perimetro = lado1 + lado2 + lado3;
        perimetroInput.value = perimetro.toFixed(2);
        calculoRealizado = true;
    } else {
        perimetroInput.value = '';
    }

    return calculoRealizado;
}

document.addEventListener('DOMContentLoaded', function () {
    const inputs = ['txtBase', 'txtAltura', 'txtLado1', 'txtLado2', 'txtLado3'];

    inputs.forEach(function (id) {
        const el = document.getElementById(id);
        if (el) {
            el.addEventListener('input', function () {
                if (id === 'txtBase') {
                    const l1 = document.getElementById('txtLado1');
                    if (l1 && (l1.value === '' || l1.dataset.auto === 'true')) {
                        l1.value = el.value;
                        l1.dataset.auto = 'true';
                    }
                }
                if (id === 'txtLado1') {
                    el.dataset.auto = 'false';
                }
                calcularTriangulo();
            });
        }
    });

    const btnCalcular = document.getElementById('btnCalcular');
    if (btnCalcular) {
        btnCalcular.addEventListener('click', function () {
            const baseInput = document.getElementById('txtBase');
            const alturaInput = document.getElementById('txtAltura');
            const lado1Input = document.getElementById('txtLado1');
            const lado2Input = document.getElementById('txtLado2');
            const lado3Input = document.getElementById('txtLado3');

            const base = parseFloat(baseInput?.value);
            const altura = parseFloat(alturaInput?.value);
            const lado1 = parseFloat(lado1Input?.value);
            const lado2 = parseFloat(lado2Input?.value);
            const lado3 = parseFloat(lado3Input?.value);

            if (isNaN(base) || base <= 0) {
                alert('Por favor ingrese una base válida mayor a cero.');
                baseInput?.focus();
                return;
            }

            if (isNaN(altura) || altura <= 0) {
                alert('Por favor ingrese una altura válida mayor a cero.');
                alturaInput?.focus();
                return;
            }

            if (isNaN(lado1) || lado1 <= 0 || isNaN(lado2) || lado2 <= 0 || isNaN(lado3) || lado3 <= 0) {
                alert('Por favor complete los 3 lados válidos mayores a cero para calcular el perímetro.');
                return;
            }

            if (!esTrianguloValido(lado1, lado2, lado3)) {
                alert('Las longitudes ingresadas no forman un triángulo válido.');
                return;
            }

            calcularTriangulo();
        });
    }

    // Calcular valores iniciales si estamos en modo edición
    calcularTriangulo();
});

function esTrianguloValido(lado1, lado2, lado3) {
    return lado1 + lado2 > lado3 &&
        lado1 + lado3 > lado2 &&
        lado2 + lado3 > lado1;
}
