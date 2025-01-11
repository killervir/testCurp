<?php

/**
 * testCurp.php
 *
 * @category PHP
 * @copyright 2025 Copyright(c) TestCurp
 * @Author Angel Amador
 */

/// Enumeración para el sexo.
abstract class Sexo
{
    const Masculino = 1;
    const Femenino = 2;
}

// Clase para manejar la validación de CURP.
class ValidadorCURP
{
    public static function validar(array $datosEntrada): array
    {
        $errores = [];

        // Extraer datos de entrada.
        $curp = strtoupper($datosEntrada['curp']);
        $nombres = strtoupper($datosEntrada['nombres']);
        $apellidoPaterno = strtoupper($datosEntrada['apelldoPaterno']);
        $apellidoMaterno = strtoupper($datosEntrada['apellidoMaterno']);
        $fechaNacimiento = $datosEntrada['fechaNacimiento'];
        $sexo = $datosEntrada['sexo'];
        $esMexicano = $datosEntrada['esMexicano'];

        // Validar longitud del CURP.
        if (strlen($curp) !== 18) {
            $errores[] = "El CURP debe tener exactamente 18 caracteres.";
        }

        // Validar estructura del CURP.
        if (!preg_match('/^[A-Z]{4}\d{6}[HM][A-Z]{5}\d{2}$/', $curp)) {
            $errores[] = "El CURP tiene un formato inválido.";
        }

        // Validar iniciales del CURP contra nombres y apellidos.
        $inicialesEsperadas = substr($apellidoPaterno, 0, 1) . self::primeraVocal($apellidoPaterno) . substr(
                $apellidoMaterno,
                0,
                1
            ) . substr($nombres, 0, 1);
        if (substr($curp, 0, 4) !== $inicialesEsperadas) {
            $errores[] = "Las iniciales del CURP no coinciden con los nombres y apellidos.";
        }

        // Validar fecha de nacimiento.
        $fechaCurp = substr($curp, 4, 6);
        $fechaEsperada = date('ymd', strtotime($fechaNacimiento));
        if ($fechaCurp !== $fechaEsperada) {
            $errores[] = "La fecha de nacimiento en el CURP no coincide.";
        }

        // Validar género.
        $generoCurp = substr($curp, 10, 1);
        $generoEsperado = $sexo === Sexo::Masculino ? 'H' : 'M';
        if ($generoCurp !== $generoEsperado) {
            $errores[] = "El género en el CURP no coincide.";
        }

        // Validar estado de nacimiento.
        $estadoCurp = substr($curp, 11, 2);
        if ($esMexicano) {
            if (!self::esEstadoValido($estadoCurp)) {
                $errores[] = "El estado de nacimiento en el CURP es inválido.";
            }
        } else {
            if ($estadoCurp !== 'NE') {
                $errores[] = "El estado de nacimiento para extranjeros debe ser 'NE'.";
            }
        }

        return $errores;
    }

    private static function primeraVocal(string $texto): string
    {
        preg_match('/[AEIOU]/', substr($texto, 1), $coincidencias);
        return $coincidencias[0] ?? '';
    }

    private static function esEstadoValido(string $estado): bool
    {
        $estadosValidos = [
            'AS',
            'BC',
            'BS',
            'CC',
            'CL',
            'CM',
            'CS',
            'CH',
            'DF',
            'DG',
            'GT',
            'GR',
            'HG',
            'JC',
            'MC',
            'MN',
            'MS',
            'NT',
            'NL',
            'OC',
            'PL',
            'QT',
            'QR',
            'SP',
            'SL',
            'SR',
            'TC',
            'TS',
            'TL',
            'VZ',
            'YN',
            'ZS'
        ];
        return in_array($estado, $estadosValidos);
    }
}

// Ejemplo de uso.
//Datos validos
$datosEntrada = [
    'curp' => 'GOCJ920701HDFRLL04',
    'nombres' => 'Juan',
    'apelldoPaterno' => 'Gomez',
    'apellidoMaterno' => 'Cruz',
    'fechaNacimiento' => '1992-07-01T06:00:00.000Z',
    'sexo' => Sexo::Masculino,
    'esMexicano' => true,
];

$errores = ValidadorCURP::validar($datosEntrada);

if (empty($errores)) {
    echo json_encode([]); // Retorna un arreglo vacío si no hay errores.
} else {
    echo json_encode($errores); // Retorna los errores en formato JSON.
}
