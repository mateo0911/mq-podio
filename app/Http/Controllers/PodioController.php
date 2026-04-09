<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class PodioController extends Controller
{
    public function index()
    {
        $areas = $this->getAreas();

        return view('podio.index', compact('areas'));
    }

    private function getAreas(): array
    {
        $troqueladores = [
            ['nombre' => 'Carlos Méndez', 'puntos' => 980, 'genero' => 'M'],
            ['nombre' => 'María López', 'puntos' => 945, 'genero' => 'F'],
            ['nombre' => 'José Ramírez', 'puntos' => 920, 'genero' => 'M'],
            ['nombre' => 'Ana Castillo', 'puntos' => 890, 'genero' => 'F'],
            ['nombre' => 'Pedro Herrera', 'puntos' => 875, 'genero' => 'M'],
            ['nombre' => 'Lucía Morales', 'puntos' => 860, 'genero' => 'F'],
            ['nombre' => 'Fernando Díaz', 'puntos' => 840, 'genero' => 'M'],
            ['nombre' => 'Rosa Gutiérrez', 'puntos' => 815, 'genero' => 'F'],
            ['nombre' => 'Miguel Torres', 'puntos' => 800, 'genero' => 'M'],
            ['nombre' => 'Carmen Flores', 'puntos' => 785, 'genero' => 'F'],
            ['nombre' => 'Roberto Vargas', 'puntos' => 770, 'genero' => 'M'],
            ['nombre' => 'Elena Jiménez', 'puntos' => 755, 'genero' => 'F'],
            ['nombre' => 'Andrés Rojas', 'puntos' => 740, 'genero' => 'M'],
            ['nombre' => 'Patricia Soto', 'puntos' => 720, 'genero' => 'F'],
            ['nombre' => 'Diego Navarro', 'puntos' => 705, 'genero' => 'M'],
            ['nombre' => 'Sofía Peña', 'puntos' => 690, 'genero' => 'F'],
            ['nombre' => 'Raúl Campos', 'puntos' => 670, 'genero' => 'M'],
        ];

        $impresores = [
            ['nombre' => 'Alejandro Ruiz', 'puntos' => 995, 'genero' => 'M'],
            ['nombre' => 'Valentina Cruz', 'puntos' => 960, 'genero' => 'F'],
            ['nombre' => 'Héctor Sandoval', 'puntos' => 935, 'genero' => 'M'],
            ['nombre' => 'Isabel Montes', 'puntos' => 910, 'genero' => 'F'],
            ['nombre' => 'Ricardo Paredes', 'puntos' => 885, 'genero' => 'M'],
            ['nombre' => 'Gabriela Vega', 'puntos' => 865, 'genero' => 'F'],
            ['nombre' => 'Óscar Delgado', 'puntos' => 845, 'genero' => 'M'],
            ['nombre' => 'Daniela Ríos', 'puntos' => 825, 'genero' => 'F'],
            ['nombre' => 'Javier Espinoza', 'puntos' => 810, 'genero' => 'M'],
            ['nombre' => 'Mónica Acosta', 'puntos' => 790, 'genero' => 'F'],
            ['nombre' => 'Luis Guerrero', 'puntos' => 775, 'genero' => 'M'],
            ['nombre' => 'Adriana Molina', 'puntos' => 760, 'genero' => 'F'],
            ['nombre' => 'Sergio Bautista', 'puntos' => 745, 'genero' => 'M'],
            ['nombre' => 'Laura Pacheco', 'puntos' => 725, 'genero' => 'F'],
            ['nombre' => 'Francisco León', 'puntos' => 710, 'genero' => 'M'],
            ['nombre' => 'Natalia Duarte', 'puntos' => 695, 'genero' => 'F'],
            ['nombre' => 'Emilio Contreras', 'puntos' => 675, 'genero' => 'M'],
        ];

        $guillotinistas = [
            ['nombre' => 'Manuel Salazar', 'puntos' => 970, 'genero' => 'M'],
            ['nombre' => 'Carolina Fuentes', 'puntos' => 950, 'genero' => 'F'],
            ['nombre' => 'Arturo Medina', 'puntos' => 925, 'genero' => 'M'],
            ['nombre' => 'Teresa Ibarra', 'puntos' => 900, 'genero' => 'F'],
            ['nombre' => 'Guillermo Ponce', 'puntos' => 880, 'genero' => 'M'],
            ['nombre' => 'Verónica Estrada', 'puntos' => 855, 'genero' => 'F'],
            ['nombre' => 'Enrique Mejía', 'puntos' => 835, 'genero' => 'M'],
            ['nombre' => 'Paula Córdova', 'puntos' => 820, 'genero' => 'F'],
            ['nombre' => 'Iván Quintero', 'puntos' => 805, 'genero' => 'M'],
            ['nombre' => 'Claudia Rangel', 'puntos' => 788, 'genero' => 'F'],
            ['nombre' => 'Tomás Villareal', 'puntos' => 772, 'genero' => 'M'],
            ['nombre' => 'Mariana Ochoa', 'puntos' => 758, 'genero' => 'F'],
            ['nombre' => 'Rubén Galván', 'puntos' => 742, 'genero' => 'M'],
            ['nombre' => 'Silvia Lara', 'puntos' => 728, 'genero' => 'F'],
            ['nombre' => 'Nicolás Aguilar', 'puntos' => 712, 'genero' => 'M'],
            ['nombre' => 'Fernanda Zavala', 'puntos' => 698, 'genero' => 'F'],
            ['nombre' => 'Martín Pedraza', 'puntos' => 680, 'genero' => 'M'],
        ];

        return [
            [
                'nombre' => 'Troqueladores',
                'icono' => 'fa-gears',
                'color' => '#6366f1',
                'empleados' => $this->processEmpleados($troqueladores),
            ],
            [
                'nombre' => 'Impresores',
                'icono' => 'fa-print',
                'color' => '#06b6d4',
                'empleados' => $this->processEmpleados($impresores),
            ],
            [
                'nombre' => 'Guillotinistas',
                'icono' => 'fa-scissors',
                'color' => '#f59e0b',
                'empleados' => $this->processEmpleados($guillotinistas),
            ],
        ];
    }

    private function processEmpleados(array $empleados): array
    {
        usort($empleados, fn($a, $b) => $b['puntos'] - $a['puntos']);

        foreach ($empleados as $i => &$emp) {
            $emp['posicion'] = $i + 1;
            $emp['medalla'] = match ($i) {
                0 => 'oro',
                1 => 'plata',
                2 => 'bronce',
                default => null,
            };

            // Avatar: no API, just a placeholder flag
            $emp['avatar'] = null;
        }

        return $empleados;
    }
}
