<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\EstrategiaWMS;
use App\Models\EstrategiaWMSHorarioPrioridade;
use Carbon\Carbon;
use Illuminate\Http\Request;

class StrategyController extends Controller
{



    public function store(Request $request)
    {

        $request->validate([
            'dsEstrategia' => 'required|string',
            'nrPrioridade' => 'required|integer',
            'horarios' => 'required|array',
            'horarios.*.dsHorarioInicio' => 'required|string',
            'horarios.*.dsHorarioFinal' => 'required|string',
            'horarios.*.nrPrioridade' => 'required|integer',
        ]);

        $estrategiaWMS = EstrategiaWMS::create([
            'ds_estrategia_wms' => $request->dsEstrategia,
            'nr_prioridade' => $request->nrPrioridade,
        ]);

        // dd($request->horarios);
        foreach ($request->horarios as $horario) {
            EstrategiaWMSHorarioPrioridade::create([
                'cd_estrategia_wms' => $estrategiaWMS->cd_estrategia_wms,
                'ds_horario_inicio' => $horario['dsHorarioInicio'],
                'ds_horario_final' => $horario['dsHorarioFinal'],
                'nr_prioridade' => $horario['nrPrioridade']
            ]);
        }

        return response()->json(['message' => 'Estratégia WMS criada com sucesso'], 201);
    }

    public function getPrioridade($cdEstrategia, $dsHora, $dsMinuto)
    {

        $estrategiaWMS = EstrategiaWMS::find($cdEstrategia);

        if (!$estrategiaWMS) {
            return response()->json(['error' => 'Estratégia WMS não encontrada'], 404);
        }

        $horaMinuto = Carbon::createFromFormat('H:i', $dsHora . ':' . $dsMinuto);

        $prioridade = $estrategiaWMS->horariosPrioridade()
            ->where('ds_horario_inicio', '<=', $horaMinuto->format('H:i'))
            ->where('ds_horario_final', '>=', $horaMinuto->format('H:i'))
            ->value('nr_prioridade');

        if (!$prioridade) {

            $prioridade = $estrategiaWMS->nr_prioridade;
        }

        return response()->json(['prioridade' => $prioridade],200);
    }

}
