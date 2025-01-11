# testCurp
Evaluación técnica
Descripción del problema
Construir un validador de CURP.


<b>Formato de entrada</b>

El sistema recibirá una estructura de datos, descrita a continuación
enum Sexo {
Masculino = 1,
Femenino = 2,
}
interface DatosEntrada {
curp: string; // CURP a evaluar
nombres: string; // Nombres de pila de la persona
apelldoPaterno: string; // Apellido paterno de la persona
apellidoMaterno: string; // Apellido materno de la persona
fechaNacimiento: string; // Fecha de nacimiento de la persona, dato en formato ISO string "1992-07-01T06:00:00.000Z"
sexo: Sexo; // Género de la persona
esMexicano: boolean; // Indica si la persona es mexicana o no
}
Formato de salida
Arreglo de strings, en donde

Si hay algún error en el CURP respecto al resto de la información
o Retorna un arreglo indicando cada uno de los problemas que se encontraron respecto a la información suministrada.
Si no hay ningún problema
o Retorna un arreglo vacío.
Consideraciones

El CURP está conformado por 18 caracteres, definido en Imagen no. 1.
No se considerarán nombres o apellidos compuestos, por ejemplo “De la Cruz”, “De Jesús”
No se respetará la definido para los casos de los nombres que comienzan con “María” o “José”
Para el caso de CURP de extranjeros, el estado de nacimiento, en el CURP suministrado, debe ser “NE”
