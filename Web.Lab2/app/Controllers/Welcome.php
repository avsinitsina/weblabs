<?php namespace App\Controllers;
use App\Models\Matrix;
use CodeIgniter\HTTP\IncomingRequest;
class Welcome extends BaseController
{
    public function dialog() {
        helper('form');
        echo view('header');
        echo view('dialog');
        echo view('footer');
    }

    public function matrix() {
        echo view('header');
        
        $request = service('request');
        $result = $request->getVar('size');
        if(isset($result) && !empty($result) && is_numeric($result) && $result>1){
            $matrix = new Matrix($result, null);
        }
        else $matrix = new Matrix(null, null);

        $config         = new \Config\Encryption();
        $config->key    = 'aBigsecret_ofAtleast32Characters';
        $config->driver = 'OpenSSL';

        $encrypter = \Config\Services::encrypter($config);

        $data['title'] = "Исходная матрица размера ".$matrix->colsCount."x".$matrix->colsCount;
        $data['matrix'] = $matrix->data;
        $data['det'] = "Определитель = ".$matrix->getDeterminant();
        echo @view('matrix', $data);
        $data['det'] = null;

        file_put_contents("usermatrix.txt",  $encrypter->encrypt(json_encode($matrix->data)));

        $data['title'] = "Обратная матрица"; 
        $data['matrix'] = $matrix->getReversed()->data;
        echo @view('matrix', $data);

        $data['title'] = "Исходная, отзеркалена горизонтально";
        $data['matrix'] = @$matrix->getMirrorH()->data;
        echo @view('matrix', $data);

        $data['title'] = "Исходная, отзеркалена вертикально";
        $data['matrix'] = @$matrix->getMirrorV()->data;
        echo @view('matrix', $data);
        helper("form");
        echo view('downloadfile');
        echo view('footer');
    }

    public function matrix2(){
        echo view('header');
        helper('form');
        echo view('uploadfile');        
        $request = service('request');
        $result = $request->getFile('usermatrix');

        if(!empty($result))
        {
            $config         = new \Config\Encryption();
            $config->key    = 'aBigsecret_ofAtleast32Characters';
            $config->driver = 'OpenSSL';

            $encrypter = \Config\Services::encrypter($config);
            $json = $encrypter->decrypt(file_get_contents('usermatrix.txt'));
            $matrix = new Matrix(null, json_decode($json));

            $data['title'] = "Исходная матрица размера ".$matrix->colsCount."x".$matrix->colsCount;
            $data['matrix'] = $matrix->data;
            echo view('matrix', $data);

            $data['title'] = "Попарное чередование строк";
            $data['matrix'] = @$matrix->pairRows()->data;
            echo @view('matrix', $data);

            $data['title'] = "Попарное чередование столбцов";
            $data['matrix'] = @$matrix->pairCols()->data;
            echo @view('matrix', $data);
        }    
        echo view('footer');
    }

    public function downloadfile(){
        helper('download');
        $response = service('response');
        return $response->download("usermatrix.txt", null);
    }
}