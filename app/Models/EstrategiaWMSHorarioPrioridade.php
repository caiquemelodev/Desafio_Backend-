<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class EstrategiaWMSHorarioPrioridade extends Model
{
    use HasFactory;
    protected $table = 'tb_estrategia_wms_horario_prioridades';
    protected $primaryKey = 'cd_estrategia_wms_horario_prioridade';
    protected $fillable = ['cd_estrategia_wms', 'ds_horario_inicio', 'ds_horario_final', 'nr_prioridade'];
     public $timestamps = false;



    public function estrategiaWMS()
    {
        return $this->belongsTo(EstrategiaWMS::class, 'cd_estrategia_wms', 'cd_estrategia_wms');
    }

}
