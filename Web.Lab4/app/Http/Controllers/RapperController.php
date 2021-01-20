<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class RapperController extends Controller
{
    public function index() {
        $rapperModel = new \App\Models\Rapper();
        $rappers = $rapperModel->all();
        return view('list');
    }

    public function list($page = 1) {
        $where = [];
        $orderBy = "id";
        $orderDir = "asc";
        $rapperModel = new \App\Models\Rapper();
        $allRequests = request()->all();

        if(!empty($allRequests['filter'])) {
            $filter = json_decode($allRequests['filter']);
            if(!empty($filter)){
                foreach ($filter as $item) {
                    if($item->name === "sort_name" && $item->value !== "any") {
                        $orderBy = $item->value;
                        continue;
                    }
                    if($item->name === "sort_dir" && $orderBy !== "id") {
                        $orderDir = $item->value;
                        continue;
                    }
                    if ($item->name === 'date_before') {
                        if ($item->value !== "")
                            $where[] = ['from', '<=', $item->value];
                        continue;
                    }
                    else if ($item->name === 'date_after') {
                        if ($item->value !== "")
                            $where[] = ['from', '>=', $item->value];
                        continue;
                    }
                    if ($item->name === 'moves_max') {
                        if ($item->value !== "")
                            $where[] = ['cool_moves_count', '<=', $item->value];
                        continue;
                    }
                    else if ($item->name === 'moves_min') {
                        if ($item->value !== "")
                            $where[] = ['cool_moves_count', '>=', $item->value];
                        continue;
                    }
                    if ($item->value === 'any' || $item->value === '') continue;
                    if($item->name !== 'sort_name' && $item->name !== 'sort_dir') $where[$item->name] = $item->value;
                }
            }
        }
        return response()->json($rapperModel->readList($where, $orderBy, $orderDir, 20,$page));
    }

    public function form($id = null) {
//        helper("form");
        $title = "";
        if($id === null)
        {
            $title = "Create";
            $rapper['name'] = $rapper['label'] = $rapper['genre'] = $rapper['country'] = $rapper['swearing_frequency'] = $rapper['cool_moves_count'] = $rapper['from'] = $rapper['dead_baddy'] = null;
        }
        else
        {
            $title = "Edit";
            $rapperModel = new \App\Models\Rapper();
            $rapper = json_decode(json_encode($rapperModel->find($id)), true);
        }
        return view("form", ['rapper'=>$rapper, 'title' => $title, 'id'=> $id]);
    }

    public function delete($id) {
        $rapperModel = new \App\Models\Rapper();
        $rapperModel->deleteRecord($id);
    }

    public function store($id=null) {
        $rapperModel = new \App\Models\Rapper();
        if (request()->getMethod() === 'POST') {
            $date = NULL;
            $allRequests = request()->all();;
            if (!empty($allRequests['from'])) {
                $date = new \DateTime($allRequests['from']);
                $date = $date->format('Y-m-d');
            }
            $data = [
                'name' => $allRequests['name'],
                'label' => $allRequests['label'],
                'genre' => $allRequests['genre'],
                'dead_baddy' => $allRequests['dead_baddy'],
                'cool_moves_count' => $allRequests['cool_moves_count'],
                'swearing_frequency' => $allRequests['swearing_frequency'],
                'country' => $allRequests['country'],
                'from' => $date,
            ];
            if($id === null) {
                $rapper = $rapperModel->newInstance()->fill($data);
                $rapperModel->insertRecord($rapper);
            }
            else {
                $rapper = $rapperModel->newInstance()->fill($data);
                $rapperModel->updateRecord($id, $rapper);
            }
            return redirect()->to('/');
        }
        return $this->form($id);
    }
    public function random($id = null)
    {
        $rapperModel = new \App\Models\Rapper();
        $rapper = $rapperModel->generate();
        $title = "";
        if($id!==null) {
            $rapper['id'] = $id;
            $title = "Edit";
        }
        else {
            $title = "Create";
        }
        return view("form", ['rapper'=>$rapper, 'title' => $title, 'id'=> $id]);
    }
    public function generate()
    {
        $rapperModel = new \App\Models\Rapper();
        $allRequests = request()->all();
        $count = $allRequests['generation_count'];
        if($count !== 0 && $count !== ""){
            $data = $rapperModel->generate($count);
            if($count === 1) {
                $rapperModel->insertRecord($data);
            }
            else
            foreach($data as $record) {
                $rapperModel->insertRecord($record);
            }
        }
        return redirect()->to('/');
    }
}
