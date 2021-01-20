<?php namespace App\Controllers;
use CodeIgniter\Entity;
use CodeIgniter\HTTP\IncomingRequest;
class RapperController extends BaseController
{
    public function index() {
        $rapperModel = new \App\Models\RapperModel();
        $rappers = $rapperModel->findAll();
        return view('list');
    }

    public function list($page = 1) {
        $where = [];
        $orderBy = "id";
        $orderDir = "ASC";
        $rapperModel = new \App\Models\RapperModel();
        if(!empty($this->request->getVar('filter'))) {
            $filter = json_decode($this->request->getVar('filter'));
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
                        $where['from <='] = $item->value;
                        continue;
                    }
                    else if ($item->name === 'date_after') {
                        if ($item->value !== "")
                        $where['from >='] = $item->value;
                        continue;
                    }
                    if ($item->name === 'moves_max') {
                        if ($item->value !== "")
                            $where['cool_moves_count <='] = $item->value;
                        continue;
                    }
                    else if ($item->name === 'moves_min') {
                        if ($item->value !== "")
                            $where['cool_moves_count >='] = $item->value;
                        continue;
                    }
                    if ($item->value === 'any' || $item->value === '') continue;
                    if($item->name !== 'sort_name' && $item->name !== 'sort_dir') $where[$item->name] = $item->value;
                }
            }
        }
        return $this->response->setJSON([
            'rappers' => $rapperModel->readList($where, $orderBy, $orderDir, 20,$page),
            'pager' => $rapperModel->pager->links()
        ]);
    }

    public function form($id = null) {
        helper("form");
        $title = "";
        if($id === null)
        {
            $title = "Create";
            $rapper['name'] = $rapper['label'] = $rapper['genre'] = $rapper['country'] = $rapper['swearing_frequency'] = $rapper['cool_moves_count'] = $rapper['from'] = $rapper['dead_baddy'] = null;
        }
        else
        {
            $title = "Edit";
            $rapperModel = new \App\Models\RapperModel();
            $rapper = json_decode(json_encode($rapperModel->find($id)), true);
        }
        return view("form", ['rapper'=>$rapper, 'title' => $title, 'id'=> $id]);
    }

    public function delete($id) {
        $rapperModel = new \App\Models\RapperModel();
        $rapperModel->deleteRecord($id);
    }

    public function store($id=null) {
        $rapperModel = new \App\Models\RapperModel();
        if ($this->request->getMethod() === 'post') {
            $date = NULL;
            if (!empty($this->request->getVar('from'))) {
                $date = new \DateTime($this->request->getVar('from'));
                $date = $date->format('Y-m-d');
            }
            $data = [
                'name' => $this->request->getVar('name'),
                'label' => $this->request->getVar('label'),
                'genre' => $this->request->getVar('genre'),
                'dead_baddy' => $this->request->getVar('dead_baddy'),
                'cool_moves_count' => $this->request->getVar('cool_moves_count'),
                'swearing_frequency' => $this->request->getVar('swearing_frequency'),
                'country' => $this->request->getVar('country'),
                'from' => $date,
            ];
            if($id === null)
                $rapperModel->insertRecord($data);
            else
                $rapperModel->updateRecord($id, $data);
            return redirect()->to('/');
        }
        return $this->form($id);
    }
    public function random($id = null)
    {
        $rapperModel = new \App\Models\RapperModel();
        $rapper = $rapperModel->generate();
        $rapper['dead_baddy'] = $rapper['dead_baddy'] === 1 ? "Killed in a fight" : "Not killed in a fight";
        $rapper['from'] = \DateTime::createFromFormat('Y-m-d', $rapper['from'])->format('d.m.Y');
        $title = "";
        if($id!==null){
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
        $rapperModel = new \App\Models\RapperModel();
        $count = $this->request->getVar('generation_count');
        if($count !== 0 && $count !== ""){
            $data = $rapperModel->generate($count);
            foreach($data as $record) {
                $rapperModel->insertRecord($record);
            }
        }
        return redirect()->to('/');
    }
}