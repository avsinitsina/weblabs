<?php
namespace App\Models;
use CodeIgniter\Test\Fabricator;
class RapperModel extends \CodeIgniter\Model {
    protected $table = 'rappers';
    protected $allowedFields = ['genre', 'name', 'from', 'dead_baddy', 'cool_moves_count', 'swearing_frequency', 'country', 'label'];
    protected $returnType = 'App\Entities\Rapper';
    protected $useTimestamps = False;
    protected $validationRules  = [
        'name'                    => 'required|is_unique[rappers.name]',
        'genre'                   => 'in_list[freestyle,gangsta,hardcore,nerdcore]',
        'label'                   => 'required',
        'dead_baddy'              => 'required|in_list[0,1]',
        'from'                    => 'required|valid_date',
        'country'                 => 'required',
        'swearing_frequency'      => 'required|numeric',
        'cool_moves_count'        => 'required|numeric',
    ];
    protected $generationData;
    public function readList($where, $orderBy, $orderDir, $perPage, $page) {
        $list = $this->where($where)->orderBy($orderBy, $orderDir)->paginate($perPage,'default', $page, 2);
        $result = [];
        foreach ($list as $item) {
            $tmp = [
                'id' => $item->id,
                'name'                    => $item->name,
                'genre'                   => $item->genre,
                'label'                   => $item->label,
                'dead_baddy'              => $item->dead_baddy,
                'from'                    => $item->from,
                'country'                 => $item->country,
                'swearing_frequency'      => $item->swearing_frequency,
                'cool_moves_count'        => $item->cool_moves_count
            ];
            $result[] = $tmp;
        }
        return $result;
    }
    public function insertRecord($data = null) {
        if (!$data)
        {
            $data = $this->generate();
        }
        $validation = service('validation');
        $validation->reset();
        $validation->setRules($this->validationRules);
        if ($validation->run(json_decode(json_encode($data), true)))
        {
            return $this->builder()->insert($data, true);
        }
        else
        {
            return false;
        }
    }
    public function generate($count = null) {
        $count = (int)$count;

        $file = new \CodeIgniter\Files\File('./writable/uploads/data.json');
        $f = $file->openFile('r');
        $this->generationData = json_decode($f->fread($f->getSize()), true);

        $validation = service('validation');
        $validation->reset();
        $validation->setRules($this->validationRules);

        if ($count && is_int($count) && $count > 0)
        {
            return array_map(function($i) {
                return $this->generate();
            }, range(0, $count-1));
        }
        else {
            $isValid = false;
            while(!$isValid) {
                $names = $this->generationData['names'];
                $lastNames = $this->generationData['lastNames'];
                $labelNouns = $this->generationData['labelNouns'];
                $labelAdjectives = $this->generationData['labelAdjectives'];
                $genres = $this->generationData['genres'];
                $countries = $this->generationData['countries'];

                $nameIndex = array_rand($names);
                $name = $names[$nameIndex];

                $lastNameIndex = array_rand($lastNames);
                $lastName = $lastNames[$lastNameIndex];

                $labelNounIndex = array_rand($labelNouns);
                $labelNoun = $labelNouns[$labelNounIndex];

                $labelAdjIndex = array_rand($labelAdjectives);
                $labelAdjective = $labelAdjectives[$labelAdjIndex];

                $genreIndex = array_rand($genres);
                $genre = $genres[$genreIndex];

                $countryIndex = array_rand($countries);
                $country = $countries[$countryIndex];

                $swearingFreq = mt_rand() / mt_getrandmax();
                $coolMovesCount = rand(0, 10);
                $deadBaddy = rand(0, 1);

                $date = new \DateTime('1 January 2000');
                $dayShift = rand(-2000, 2000);
                $date->modify("+$dayShift days");
                $from = $date->format('Y-m-d');


                $data = [
                    'name' => $name . " " . $lastName,
                    'from' => $from,
                    'cool_moves_count' => $coolMovesCount,
                    'swearing_frequency' => $swearingFreq,
                    'dead_baddy' => $deadBaddy,
                    'country' => $country,
                    'label' => $labelAdjective . " " . $labelNoun,
                    'genre' => $genre
                ];
                if ($validation->run(json_decode(json_encode($data), true)))
                    $isValid = true;
            }
            return $data;
        }
    }
    public function updateRecord($id, $data) {
        $validation = service('validation');
        $validation->setRules([
            'name'          => 'required|is_unique[rappers.name]',
            'genre'          => 'required|in_list[freestyle,gangsta,hardcore,nerdcore]',
            'dead_baddy'           => 'required|in_list[Killed in a fight, Not killed in a fight]',
            'from'     => 'required|valid_date',
            'cool_moves_count'        => 'required|numeric',
            'swearing_frequency'        => 'required|numeric',
        ]);
        return $this->builder()->where('id', $id)->update($data);
    }

    public function deleteRecord($id) {
        return $this->builder()->delete('id='.$id);
    }
}