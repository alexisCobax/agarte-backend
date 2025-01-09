<?php

namespace App\Modules\Logs\Services;


class LogService
{
    private $logFile;
    private $logs = [];
    private $logsPerPage = 15;
    private $totalLogs;
    private $totalPages;

    public function __construct()
    {
        $this->logFile = dirname(__DIR__, 4) . '/public/storage/logs/app.log';
        $this->loadLogs();
    }

    private function loadLogs()
{
    if (file_exists($this->logFile)) {
        $lines = file($this->logFile, FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES);
        $currentLog = [];
        foreach ($lines as $line) {
            if (preg_match('/^\[(.*?)\] \[(.*?)\]/', $line, $matches)) {
                // Si ya estamos procesando un log, lo agregamos a la lista
                if (!empty($currentLog)) {
                    $this->logs[] = $currentLog;
                }

                // Comenzamos un nuevo log
                $currentLog = [
                    'date' => $matches[1],
                    'level' => $matches[2],
                    'message' => strlen($line) > 100 ? substr($line, 0, 100) . '...' : $line, // Resumen del mensaje
                    'full_message' => $line // Guardar el mensaje completo
                ];
            } else {
                // Si no es una nueva entrada, agregamos la línea al log actual
                if (!empty($currentLog)) {
                    $currentLog['full_message'] .= "\n" . $line;
                }
            }
        }
        // Agregamos el último log procesado
        if (!empty($currentLog)) {
            $this->logs[] = $currentLog;
        }
        // Ordenar por fecha (más reciente primero)
        usort($this->logs, function ($a, $b) {
            return strtotime($b['date']) - strtotime($a['date']);
        });
    }

    $this->totalLogs = count($this->logs);
    $this->totalPages = ceil($this->totalLogs / $this->logsPerPage);
}


//     private function loadLogs()
// {
//     if (file_exists($this->logFile)) {
//         $lines = file($this->logFile, FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES);
//         $currentLog = [];
//         foreach ($lines as $line) {
//             if (preg_match('/^\[(.*?)\] \[(.*?)\]/', $line, $matches)) {
//                 // Si ya estamos procesando un log, lo agregamos a la lista
//                 if (!empty($currentLog)) {
//                     $this->logs[] = $currentLog;
//                 }
//                 // Comenzamos un nuevo log
//                 $currentLog = [
//                     'date' => $matches[1],
//                     'level' => $matches[2],
//                     'message' => $line
//                 ];
//             } else {
//                 // Si no es una nueva entrada, agregamos la línea al log actual
//                 if (!empty($currentLog)) {
//                     $currentLog['message'] .= "\n" . $line;
//                 }
//             }
//         }
//         // Agregamos el último log procesado
//         if (!empty($currentLog)) {
//             $this->logs[] = $currentLog;
//         }
//         // Ordenar por fecha (más reciente primero)
//         usort($this->logs, function ($a, $b) {
//             return strtotime($b['date']) - strtotime($a['date']);
//         });
//     }

//     $this->totalLogs = count($this->logs);
//     $this->totalPages = ceil($this->totalLogs / $this->logsPerPage);
// }


    // private function loadLogs()
    // {
    //     if (file_exists($this->logFile)) {
    //         $lines = file($this->logFile, FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES);
    //         foreach ($lines as $line) {
    //             preg_match('/\[(.*?)\] \[(.*?)\] (.*)/', $line, $matches);
    //             if ($matches) {
    //                 $this->logs[] = [
    //                     'date' => $matches[1],
    //                     'level' => $matches[2],
    //                     'message' => $matches[3]
    //                 ];
    //             }
    //         }
    //         // Ordenar por fecha (más reciente primero)
    //         usort($this->logs, function ($a, $b) {
    //             return strtotime($b['date']) - strtotime($a['date']);
    //         });
    //     }

    //     $this->totalLogs = count($this->logs);
    //     $this->totalPages = ceil($this->totalLogs / $this->logsPerPage);
    // }

    public function getPaginatedLogs($page)
    {
        $startIndex = ($page - 1) * $this->logsPerPage;
        return array_slice($this->logs, $startIndex, $this->logsPerPage);
    }

    public function getPaginationData()
    {
        return [
            'totalLogs' => $this->totalLogs,
            'totalPages' => $this->totalPages,
        ];
    }

    public function deleteSelectedLogs($selectedLogs)
    {
        $lines = file($this->logFile, FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES);
        $updatedLines = array_filter($lines, function ($line, $index) use ($selectedLogs) {
            return !in_array($index, $selectedLogs);
        }, ARRAY_FILTER_USE_BOTH);
        file_put_contents($this->logFile, implode(PHP_EOL, $updatedLines) . PHP_EOL);
    }

    public function deleteAllLogs()
    {
        file_put_contents($this->logFile, '');
    }

    public function getLogDetail($index)
    {
        return $this->logs[$index] ?? null;
    }

}
