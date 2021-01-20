<?php
class Matrix {
        public $data = [];
        public $rowsCount = 0;
        public $colsCount = 0;

        function __construct(int $size=null, array $data=null, $squareCheck=TRUE) {
            if(empty($data))
            {
                if(empty($size)) {
                    $this->rowsCount = $this->colsCount = rand(4,16);
                }
                else {
                    $this->rowsCount = $this->colsCount = $size;
                }

                for ($i=0; $i < $this->rowsCount; $i++) {        
                    for ($j=0; $j < $this->colsCount; $j++) { 
                        $this->data[$i][$j] = rand(-10,10);
                    }
                }
            }
            else {
                $rCount = count($data);
                $sizeError = FALSE;
                //проверка, что матрица квадратная
                if($squareCheck)
                {
                    foreach ($data as $row) {
                        if(count($row) != $rCount) {
                            $sizeError = TRUE;
                            break;
                        }
                    }
                }                
                if(!$sizeError) {    
                    unset($this->data);
                    foreach ($data as $i => $row) {
                        $this->data[$i] = $row[$i];
                    }                
                    $this->data = $data;
                    $this->rowsCount = $this->colsCount = $rCount;
                }
                else {
                    throw new Exception('Матрица не является квадратной');
                }
            }
        }

        public function print() {
            echo '<table>';
            
            foreach ($this->data as $row) {  
                echo '<tr>';  
                foreach ($row as $value) {
                    echo "<td>".$value."</td>"; 
                }
                echo '</td>';
            }        
            echo '</table>';
        }

        function getMinor($i, $j) {
            $M = new Matrix(null, $this->data);
            for($m = 0; $m < $M->rowsCount; $m++) {
                for($k = 0; $k < $M->colsCount; $k++) {                    
                    if($j < $k && $i < $m) {
                        $M->data[$m-1][$k-1] = $M->data[$m][$k];
                    }
                    else if($j < $k){
                        $M->data[$m][$k-1] = $M->data[$m][$k];
                    }
                    else if($i < $m){
                        $M->data[$m-1][$k] = $M->data[$m][$k];
                    }                    
                }
            }   
            for($m = 0; $m < $M->rowsCount+1; $m++){
                unset($M->data[$m][$M->colsCount-1]);
            }
            unset($M->data[$M->colsCount-1]);
            $M->rowsCount--;
            $M->colsCount--;            
            return $M;
        }
        
        function transpose()
        {
            $buf = new Matrix(null, $this->data);
            foreach ($buf->data as $i => $row) {
                foreach ($row as $j => $value) {
                    $this->data[$i][$j] = $buf->data[$j][$i];
                }
            }            
        }
        public function getDeterminant()
        {
            if($this->colsCount == 1)
            {
                return $this->data[0][0];
            }
            $signum = 1;
            $det = 0;
            
            for ($j=0; $j < $this->colsCount; $j++) { 
                $minor = $this->getMinor(0,$j);
                $res = $minor->getDeterminant();
                $det += $this->data[0][$j]*$signum*$res;
                $signum *= -1;         
            }
            return $det;
        }

        public function getReversed()
        { 
            $det = $this->getDeterminant();
            $reversed = new Matrix(null, $this->data);
            $transposed = new Matrix(null, $this->data);
            $transposed->transpose();
            if($det)
            {
                for($i = 0; $i < $transposed->rowsCount; $i++) {
                    for ($j = 0; $j < $transposed->colsCount; $j++) { 
                        $minor = $transposed->getMinor($i,$j);
                        $reversed->data[$i][$j] = pow(-1, $i + $j)*$minor->getDeterminant()/$det;
                    }
                }
            }            
            return $reversed;
        }

        public function getMirrorH()
        {
            $result = new Matrix(null, $this->data);
            for($i = 0; $i <= floor($this->rowsCount/2); $i++)
                {
                    $result->data[$i] = $this->data[$this->rowsCount-$i];
                    $result->data[$this->rowsCount-$i] = $this->data[$i];
                }
            return $result;
        }

        public function getMirrorV()
        {
            $result = new Matrix(null, $this->data);
            for($i = 0; $i <= $this->rowsCount; $i++)
                for($j = 0; $j <= floor($this->colsCount/2); $j++)
                    {
                        $result->data[$i][$j] = $this->data[$i][$this->colsCount-$j];
                        $result->data[$i][$this->colsCount-$j] = $this->data[$i][$j];
                    }
            return $result;            
        }

        public function pairRows()
        {
            $result = new Matrix(null, $this->data);
            for($i = 0; $i < $this->rowsCount; $i+=2)
                {
                    $result->data[$i] = $this->data[$i+1];
                    $result->data[$i+1] = $this->data[$i];
                }
            return $result;
        }

        public function pairCols()
        {
            $result = new Matrix(null, $this->data);
            for($i = 0; $i <= $this->rowsCount; $i++)
                for($j = 0; $j < $this->colsCount; $j+=2)
                    {
                        $result->data[$i][$j] = $this->data[$i][$j+1];
                        $result->data[$i][$j+1] = $this->data[$i][$j];
                    }
            return $result; 
        }
    }    
?>