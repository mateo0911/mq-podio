<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class PodioController extends Controller
{
    public function index()
    {
        $areas = $this->getAreas();
        $areaRanking = $this->getAreaRanking($areas);

        return view('podio.index', compact('areas', 'areaRanking'));
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

        $auxiliares = [
            ['nombre' => 'Kevin Andrade', 'puntos' => 930, 'genero' => 'M'],
            ['nombre' => 'Paola Cedeño', 'puntos' => 910, 'genero' => 'F'],
            ['nombre' => 'Byron Zambrano', 'puntos' => 895, 'genero' => 'M'],
            ['nombre' => 'Tatiana Bravo', 'puntos' => 880, 'genero' => 'F'],
            ['nombre' => 'Jorge Galarza', 'puntos' => 865, 'genero' => 'M'],
            ['nombre' => 'Mireya Jurado', 'puntos' => 850, 'genero' => 'F'],
            ['nombre' => 'Cristian Mera', 'puntos' => 835, 'genero' => 'M'],
            ['nombre' => 'Erika Vintimilla', 'puntos' => 820, 'genero' => 'F'],
            ['nombre' => 'Ronaldo Vera', 'puntos' => 805, 'genero' => 'M'],
            ['nombre' => 'Karla Quinde', 'puntos' => 790, 'genero' => 'F'],
            ['nombre' => 'Álvaro Chica', 'puntos' => 775, 'genero' => 'M'],
            ['nombre' => 'Nayeli Proaño', 'puntos' => 760, 'genero' => 'F'],
            ['nombre' => 'Mateo Pita', 'puntos' => 748, 'genero' => 'M'],
            ['nombre' => 'Ruth Montalvo', 'puntos' => 735, 'genero' => 'F'],
            ['nombre' => 'Ernesto Cueva', 'puntos' => 720, 'genero' => 'M'],
            ['nombre' => 'Diana Cornejo', 'puntos' => 705, 'genero' => 'F'],
            ['nombre' => 'Joel Valencia', 'puntos' => 690, 'genero' => 'M'],
        ];

        $litografos = [
            ['nombre' => 'Esteban Ruilova', 'puntos' => 955, 'genero' => 'M'],
            ['nombre' => 'Andrea Burbano', 'puntos' => 938, 'genero' => 'F'],
            ['nombre' => 'Simón Alvarado', 'puntos' => 920, 'genero' => 'M'],
            ['nombre' => 'Milena Rosales', 'puntos' => 902, 'genero' => 'F'],
            ['nombre' => 'Pablo Cárdenas', 'puntos' => 886, 'genero' => 'M'],
            ['nombre' => 'Belén Narváez', 'puntos' => 870, 'genero' => 'F'],
            ['nombre' => 'Renato Freire', 'puntos' => 854, 'genero' => 'M'],
            ['nombre' => 'Noelia Jaramillo', 'puntos' => 840, 'genero' => 'F'],
            ['nombre' => 'Cristóbal Endara', 'puntos' => 825, 'genero' => 'M'],
            ['nombre' => 'Yadira Loza', 'puntos' => 808, 'genero' => 'F'],
            ['nombre' => 'Nicolás Alvear', 'puntos' => 792, 'genero' => 'M'],
            ['nombre' => 'Brenda Aulestia', 'puntos' => 778, 'genero' => 'F'],
            ['nombre' => 'Tomás Naranjo', 'puntos' => 764, 'genero' => 'M'],
            ['nombre' => 'Fernanda Moya', 'puntos' => 748, 'genero' => 'F'],
            ['nombre' => 'Gabriel Viera', 'puntos' => 732, 'genero' => 'M'],
            ['nombre' => 'Lisseth Orellana', 'puntos' => 718, 'genero' => 'F'],
            ['nombre' => 'Ariel Segura', 'puntos' => 700, 'genero' => 'M'],
        ];

        $operarios = [
            ['nombre' => 'Darío Ulloa', 'puntos' => 940, 'genero' => 'M'],
            ['nombre' => 'Karina Gamboa', 'puntos' => 922, 'genero' => 'F'],
            ['nombre' => 'Wilson Tapia', 'puntos' => 905, 'genero' => 'M'],
            ['nombre' => 'Jessica Almeida', 'puntos' => 890, 'genero' => 'F'],
            ['nombre' => 'Rafael Caicedo', 'puntos' => 875, 'genero' => 'M'],
            ['nombre' => 'Lorena Rivas', 'puntos' => 860, 'genero' => 'F'],
            ['nombre' => 'Jonathan Cobo', 'puntos' => 846, 'genero' => 'M'],
            ['nombre' => 'Vanessa Chiluisa', 'puntos' => 832, 'genero' => 'F'],
            ['nombre' => 'Santiago Lema', 'puntos' => 816, 'genero' => 'M'],
            ['nombre' => 'Marlene Guacho', 'puntos' => 802, 'genero' => 'F'],
            ['nombre' => 'Patricio Asanza', 'puntos' => 787, 'genero' => 'M'],
            ['nombre' => 'Daniela Celi', 'puntos' => 772, 'genero' => 'F'],
            ['nombre' => 'Mauricio Aguiar', 'puntos' => 758, 'genero' => 'M'],
            ['nombre' => 'Pamela Yánez', 'puntos' => 744, 'genero' => 'F'],
            ['nombre' => 'Ricardo Cacuango', 'puntos' => 730, 'genero' => 'M'],
            ['nombre' => 'Denisse Enríquez', 'puntos' => 716, 'genero' => 'F'],
            ['nombre' => 'Fernando Jumbo', 'puntos' => 700, 'genero' => 'M'],
        ];

        $plegadores = [
            ['nombre' => 'Ulises Cárdenas', 'puntos' => 950, 'genero' => 'M'],
            ['nombre' => 'Camila Guaraca', 'puntos' => 932, 'genero' => 'F'],
            ['nombre' => 'David Guevara', 'puntos' => 914, 'genero' => 'M'],
            ['nombre' => 'Sonia Peralta', 'puntos' => 896, 'genero' => 'F'],
            ['nombre' => 'Henry Morocho', 'puntos' => 880, 'genero' => 'M'],
            ['nombre' => 'Viviana Peñafiel', 'puntos' => 864, 'genero' => 'F'],
            ['nombre' => 'Brian Montero', 'puntos' => 848, 'genero' => 'M'],
            ['nombre' => 'Mayra Chicaiza', 'puntos' => 833, 'genero' => 'F'],
            ['nombre' => 'Leonardo Cadena', 'puntos' => 818, 'genero' => 'M'],
            ['nombre' => 'María José Calvopiña', 'puntos' => 804, 'genero' => 'F'],
            ['nombre' => 'Diego Larrea', 'puntos' => 788, 'genero' => 'M'],
            ['nombre' => 'Luisa Chango', 'puntos' => 774, 'genero' => 'F'],
            ['nombre' => 'Hernán Suárez', 'puntos' => 760, 'genero' => 'M'],
            ['nombre' => 'Mónica Cañar', 'puntos' => 746, 'genero' => 'F'],
            ['nombre' => 'Sergio Cañizares', 'puntos' => 732, 'genero' => 'M'],
            ['nombre' => 'Rocío Basantes', 'puntos' => 718, 'genero' => 'F'],
            ['nombre' => 'Alexis Villegas', 'puntos' => 704, 'genero' => 'M'],
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
            [
                'nombre' => 'Auxiliares',
                'icono' => 'fa-people-group',
                'color' => '#10b981',
                'empleados' => $this->processEmpleados($auxiliares),
            ],
            [
                'nombre' => 'Litógrafos',
                'icono' => 'fa-palette',
                'color' => '#ec4899',
                'empleados' => $this->processEmpleados($litografos),
            ],
            [
                'nombre' => 'Operarios',
                'icono' => 'fa-industry',
                'color' => '#3b82f6',
                'empleados' => $this->processEmpleados($operarios),
            ],
            [
                'nombre' => 'Plegadores',
                'icono' => 'fa-layer-group',
                'color' => '#ef4444',
                'empleados' => $this->processEmpleados($plegadores),
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

    private function getAreaRanking(array $areas): array
    {
        $ranking = array_map(function ($area) {
            $total = array_reduce($area['empleados'], fn($carry, $emp) => $carry + $emp['puntos'], 0);

            return [
                'nombre' => $area['nombre'],
                'icono' => $area['icono'],
                'color' => $area['color'],
                'total_puntos' => $total,
                'cantidad_empleados' => count($area['empleados']),
            ];
        }, $areas);

        usort($ranking, fn($a, $b) => $b['total_puntos'] <=> $a['total_puntos']);

        foreach ($ranking as $i => &$area) {
            $area['posicion'] = $i + 1;
            $area['medalla'] = match ($i) {
                0 => 'oro',
                1 => 'plata',
                2 => 'bronce',
                default => null,
            };
        }

        return $ranking;
    }
}
