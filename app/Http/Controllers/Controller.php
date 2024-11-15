<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Support\Facades\DB;

class Controller extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;

    public function getProject()
    {
        $sql = "SELECT DISTINCT entity_cd, project_no FROM mgr.blast_doc WHERE entity_cd = ?";
        $data = DB::select($sql, ['1001']);
        $comboProject[] = '';

        if (!empty($data)) {
            $comboProject[] = '<option value="all" data-ent="all">All</option>';
            foreach ($data as $dtProject) {
                $comboProject[] = '<option value="' . $dtProject->project_no . '" data-ent="' . $dtProject->entity_cd . '">' . $dtProject->entity_cd . ' - ' . $dtProject->project_no . '</option>';
            }
            $comboProject = implode("", $comboProject);
        }

        return $comboProject;
    }
}
