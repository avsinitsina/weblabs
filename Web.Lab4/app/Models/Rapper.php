<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

use Illuminate\Database\QueryException;
use Illuminate\Support\Facades\Log;
use Illuminate\Validation\Rule;
use Illuminate\Validation\ValidationException;
use Illuminate\Support\Facades\Validator;
use function GuzzleHttp\Psr7\str;

class Rapper extends Model
{
    use HasFactory;
    public $timestamps = false;
    protected $primaryKey = 'id';
    protected $fillable = ['genre', 'name', 'from', 'dead_baddy', 'cool_moves_count', 'swearing_frequency', 'country', 'label'];
    private $deads = ['Not killed in a fight', 'Killed in a fight'];

    public function getDeadBaddyAttribute($dead) {
        return $this->deads[(int) $dead];
    }
    public function setDeadBaddyAttribute($dead) {
        $this->attributes['dead_baddy'] = $dead === "Not killed in a fight" ? 0:1;
        Log::notice($dead);
    }

    public function getFromAttribute($from) {
        return \DateTime::createFromFormat('Y-m-d', $this->attributes['from'])->format('d.m.Y');
    }
//    public function setFromAttribute($from) {
//        $this->attributes['from'] = \DateTime::createFromFormat('d.m.Y', $from)->format('Y-m-d');
//    }

    public function readList($where, $orderBy, $orderDir, $perPage, $page) {
        $builder = $this->query();
        $list = $builder->where($where)->orderBy($orderBy, $orderDir)->paginate($perPage, ['*'], '', $page);
        $pager = $list->onEachSide(2)->links('pagination')->toHtml();
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
        return ['rappers'=>$result, 'pager'=>$pager];
    }
    public function find($id) {
        $builder = $this->query();
        return $builder->find($id);
    }
    public function insertRecord($data = null) {
        if (!$data)
        {
            $data = $this->generate();
        }
        try {
            $data = $data->attributes;
            Validator::make($data, [
                'name' => [
                    'required',
                    'unique:rappers,name',
                    'regex:/^[a-zA-Z]+ [a-zA-Z]+$/u'
                ],
                'genre' => ['required', Rule::in(["freestyle", "gangsta", "nerdcore", "hardcore"])],
                'dead_baddy' => ['required', Rule::in([0, 1])],
                'from' => ['required', 'date'],
                'country' => ['required', 'regex:/^([a-zA-Z]+ ?)+$/u'],
                'label' => ['required', 'regex:/^([a-zA-Z]+ ?)+$/u'],
                'cool_moves_count' => ['required', 'gte:0'],
                'swearing_frequency' => ['required', 'gte:0'],
            ])->validate();
            Log::notice($data);
            return $this->query()->insert($data);
        } catch(ValidationException $e) {
            return false;
        } catch(QueryException $e) {
            return false;
        }
    }

    public function updateRecord($id, $data) {
        try {
            $data = $data->attributes;
            Validator::make($data, [
                'name' => [
                    'required',
                    Rule::unique("rappers", "name")->ignore($id, "id"),
                    'regex:/^[a-zA-Z]+ [a-zA-Z]+$/u'
                ],
                'genre' => ['required', Rule::in(["freestyle", "gangsta", "nerdcore", "hardcore"])],
                'dead_baddy' => ['required', Rule::in([0, 1])],
                'from' => ['required', 'date'],
                'country' => ['required', 'regex:/^([a-zA-Z]+ ?)+$/u'],
                'label' => ['required', 'regex:/^([a-zA-Z]+ ?)+$/u'],
                'cool_moves_count' => ['required', 'gte:0'],
                'swearing_frequency' => ['required', 'gte:0'],
            ])->validate();
            return $this->query()->where("id", "=", $id)->update($data);
        } catch(ValidationException $e) {
            Log::notice($e->validator->failed());
            return false;
        } catch(QueryException $e) {
            return false;
        }
    }

    public function deleteRecord($id) {
        return $this->query()->where("id", "=", $id)->delete();
    }

    public function generate($count = null) {
        $count = (int) $count;
        if ($count > 1)
        return array_map(function ($x) {
            return $this->factory()->makeOne();
        }, range(1, $count));
        else
            return $this->factory()->makeOne();
    }
}
