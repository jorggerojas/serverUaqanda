/*
* Función: pre_hash(str)
* @author: Mendoza Burgos Rubén Andrés (ramby)
*
* El objetivo de esta función es mandar los datos 'hasheados' antes de que lleguen al servidor.
* El resultado de esta función es un hash de 24 caracteres
*
* */

function pre_hash(str) {
    /*
    * Se hace una suma de los números ascii de cada caracter de la cadena que pasa como parámetro.
    *
    * También se crea una función que es capaz de realizar dicha suma.
    *
    * */

    function ascii_sum(str) {
        sum = 0;
        splited_str = str.split('');
        for (i = 0; i < splited_str.length; i++) {
            sum += splited_str[i].charCodeAt(0);
        }
        return sum;
    }

    /*
    * La suma de los números ascii se multiplica por la superficie de Dinamarca (en kilómetros cuadrados),
    * esto nos deja con un número 'aleatorio'.
    *
    * */

    DEN_SURF = 43094;
    DEMIRANDOM = (DEN_SURF * ascii_sum(str)).toString();
    RANDOM_CHARS = ['8', 'v', 'w', 'a', 'q', 'j', 'c', 'b', 'p', '5'];
    FINAL_HASH = '';

    /*
    * En base al número pseudoaleatorio generado tomamos caracteres de un arreglo que tiene caracteres
    * ya definidos.
    *
    * Considerando que el resultado mínimo de la multiplicación de la superficie de Dinamarca es de 6 cifras
    * tomamos 6 como el máximo número de iteraciones.
    *
    * */

    DEMI_INDEXES = DEMIRANDOM.split('');

    for (i = 0; i < 6; i++) {
        FINAL_HASH += RANDOM_CHARS[parseInt(DEMI_INDEXES[i])];
    }

    /*
    * Se reemplaza el arreglo de los caracteres aleatorios con otros distintos y también se reemplaza el valor
    * 'DEMIRANDOM' por el seno de la superficie de Querétaro (en kilómetros cuadrados) y multiplicado por la suma
    * de los números ascii del string que pasa como parámetro, hacemos que el número sea positivo y quitamos el punto.
    *
    * Nuevamente vamos a obtener 6 cifras que agregaremos a la variable FINAL_HASH.
    *
    * */

    RANDOM_CHARS = ['k', '6', 'c', 'u', 'y', 'm', '1', 'q', 't', 'i'];
    QRO_SURF = 11699;
    DEMIRANDOM = (Math.abs(Math.sin(QRO_SURF) * ascii_sum(str))).toString();
    DEMI_INDEXES = DEMIRANDOM.split('');
    INDEXES = new Array();

    for (i = 0; i < DEMI_INDEXES.length; i++) {
        if (!(DEMI_INDEXES[i] === '.')) {
            INDEXES.push(parseInt(DEMI_INDEXES[i]));
        }
    }

    for (i = 0; i < 6; i++) {
        FINAL_HASH += RANDOM_CHARS[INDEXES[i]];
    }

    /*
    * Se generan los siguientes 6 caracteres para nuestra función hash, se hace algo parecido al paso anterior pero
    * esta vez haciendo uso del número 'e' y la superficie del Vaticano (en yardas cuadradas).
    *
    * */

    RANDOM_CHARS = ['o', 'w', 'f', 'h', 'z', 'r', 'a', 'm', 'b', 'y'];
    VAT_SURF = 526236;
    DEMIRANDOM = (Math.E * VAT_SURF * ascii_sum(str)).toString();
    DEMI_INDEXES = DEMIRANDOM.split('');
    NEW_INDEXES = new Array();

    for (i = 0; i < DEMI_INDEXES.length; i++) {
        if (!(DEMI_INDEXES[i] === '.')) {
            NEW_INDEXES.push(parseInt(DEMI_INDEXES[i]));
        }
    }

    for (i = 0; i < 6; i++) {
        FINAL_HASH += RANDOM_CHARS[NEW_INDEXES[i]];
    }

    /*
    * Se generan los últimos 6 caracteres para nuestra función hash, se hace algo parecido al paso anterior pero
    * esta vez haciendo uso de la función seno y la superficie de Mongolia (en kilómetros cuadradas).
    *
    * */

    RANDOM_CHARS = ['1', '0', 'm', 'z', 'x', '8', '3', 'h', 'i', 'e'];
    MON_SURF = 238397;
    DEMIRANDOM = (Math.abs(Math.sin(MON_SURF * ascii_sum(str)))).toString();
    DEMI_INDEXES = DEMIRANDOM.split('');
    NEW_INDEXES = new Array();

    for (i = 0; i < DEMI_INDEXES.length; i++) {
        if (!(DEMI_INDEXES[i] === '.')) {
            NEW_INDEXES.push(parseInt(DEMI_INDEXES[i]));
        }
    }

    for (i = 0; i < 6; i++) {
        FINAL_HASH += RANDOM_CHARS[NEW_INDEXES[i]];
    }

    /*
    * Se retorna el resultado de la función :)
    *
    * */

    return FINAL_HASH;
}