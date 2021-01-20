<?php

namespace App\Http\Controllers;

use App\Models\Rapper;
use Illuminate\Http\Request;

class RapperController extends Controller
{
    public function __construct()
    {
        $this->authorizeResource(Rapper::class, 'rapper');
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $where = [];
        $orderBy = "id";
        $orderDir = "asc";
        $rapperModel = new \App\Models\Rapper();
        $allRequests = request()->json()->all();
        //ЗАПРОС БЕЗ ПОСЛЕДНЕГО СЛЕША
        if(!empty($allRequests['filter'])) {
            $filter = json_decode(json_encode($allRequests['filter']));
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
                    if($item->name !== 'sort_name' && $item->name !== 'sort_dir') $where[] = [$item->name, '=', $item->value];
                }
            }
        }
        return response()->json($rapperModel->readList($where, $orderBy, $orderDir, 50, isset($allRequests['rank']) ? $allRequests['rank'] : 0));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $rapperModel = new \App\Models\Rapper();
        $date = NULL;
        $allRequests = $request->json()->all();
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
        $rapper = $rapperModel->newInstance()->fill($data);
        $id = $rapperModel->insertRecord($rapper);
        return response()->json(['id'=>$id]);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(Rapper $rapper)
    {
        if($rapper === null) {
            return response()->json(["message"=>"Rapper can't be found"], 404);
        }
        return response()->json($rapper);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Rapper $rapper)
    {
        if($rapper === null) {
            return response()->json(["message"=>"Rapper can't be found"], 404);
        }
        $date = NULL;
        $allRequests = $request->json()->all();
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
        $rapper = $rapper->fill($data);
        $rapperModel = new \App\Models\Rapper();
        $rapperModel->updateRecord($rapper->id, $rapper);
        return response()->json(['id'=>$rapper->id]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Rapper $rapper)
    {
        $rapperModel = new \App\Models\Rapper();
        if($rapper === null) {
            return response()->json(["message"=>"Rapper can't be found"], 404);
        }
        $rapperModel->deleteRecord($rapper->id);
        return response()->json(['status'=>"Element was successfully deleted"]);
    }
}
