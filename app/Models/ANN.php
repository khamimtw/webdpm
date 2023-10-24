<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;


class ANN extends Model
{
    protected $hiddenWeights;
    protected $hiddenBias;
    protected $outputWeights;
    protected $outputBias;

    // Fungsi aktivasi sigmoid
    function sigmoid($x)
    {
    // Fungsi ini mengambil nilai numerik $x dan mengembalikan hasil dari fungsi aktivasi sigmoid.
        return 1 / (1 + exp(-$x));
    }

    // Fungsi turunan sigmoid
    function sigmoidDerivative($x)
    {
    // Fungsi ini mengambil nilai numerik $x dan mengembalikan hasil dari turunan fungsi sigmoid.
        return $x * (1 - $x);
    }
    //fungsi ReLU
    function relu($x)
    {
    // Fungsi ReLU mengembalikan nilai $x jika $x lebih besar dari 0, dan 0 jika $x kurang dari atau sama dengan 0.
    // Fungsi ini digunakan sebagai fungsi aktivasi dalam jaringan saraf tiruan jenis ReLU.
        return max(0, $x);
    }

    //fungsi turunan ReLU
    function reluDerivative($x)
    {
    // Turunan fungsi ReLU adalah 1 jika $x lebih besar dari 0, dan 0 jika $x kurang dari atau sama dengan 0.
    // Fungsi ini digunakan dalam algoritma pembelajaran jaringan saraf tiruan dengan ReLU.
    
        return ($x > 0) ? 1 : 0;
    }
    
    //penjelasan
    
    //xavierFactorHidden adalah faktor yang digunakan untuk menginisialisasi bobot pada lapisan tersembunyi (hidden layer) dalam jaringan saraf tiruan.Faktor ini didasarkan pada metode inisialisasi bobot yang dikenal sebagai "Xavier" initialization.
    //heFactorOutput adalah faktor yang digunakan untuk menginisialisasi bobot pada lapisan keluaran (output layer) dalam jaringan saraf tiruan.Faktor ini didasarkan pada metode inisialisasi bobot yang dikenal sebagai "He" initialization
    
    public function initializeParameters($inputNeurons, $hiddenNeurons, $outputNeurons)
    {
        $this->inputNeurons = $inputNeurons;
        $this->hiddenNeurons = $hiddenNeurons;
        $this->outputNeurons = $outputNeurons;

        $this->hiddenWeights = [];
        $this->hiddenBias = [];
        $xavierFactorHidden = sqrt(1 / $this->inputNeurons);
        for ($i = 0; $i < $this->inputNeurons; $i++) {
            for ($j = 0; $j < $this->hiddenNeurons; $j++) {
                $this->hiddenWeights[$i][$j] = (mt_rand() / mt_getrandmax()) * 2 * $xavierFactorHidden - $xavierFactorHidden;
            }
        }
        $this->hiddenBias = array_fill(0, $this->hiddenNeurons, 0); 

        $this->outputWeights = [];
        $this->outputBias = [];
        $xavierFactorOutput = sqrt(1 / $this->hiddenNeurons);
        for ($i = 0; $i < $this->hiddenNeurons; $i++) {
            for ($j = 0; $j < $this->outputNeurons; $j++) {
                $this->outputWeights[$i][$j] = (mt_rand() / mt_getrandmax()) * 2 * $xavierFactorOutput - $xavierFactorOutput;
            }
        }
        $this->outputBias = array_fill(0, $this->outputNeurons, 0); 
    }
    public function feedForward($inputs)
    {
        $hiddenOutputs = [];
        $outputInputs = [];

        // Perhitungan output pada lapisan tersembunyi
        for ($i = 0; $i < $this->hiddenNeurons; $i++) {
            $sum = 0;
            for ($j = 0; $j < $this->inputNeurons; $j++) {
                // Mengalikan input dengan bobot dan menjumlahkannya
                $sum += $inputs[$j] * $this->hiddenWeights[$j][$i];
            }
            $sum += $this->hiddenBias[$i]; // Menambahkan bias
            $hiddenOutputs[$i] = $this->relu($sum);// Menggunakan fungsi aktivasi ReLU
        }

        // Perhitungan input pada lapisan keluaran
        for ($i = 0; $i < $this->outputNeurons; $i++) {
            $sum = 0;
            for ($j = 0; $j < $this->hiddenNeurons; $j++) {
                // Mengalikan output lapisan tersembunyi dengan bobot dan menjumlahkannya
                $sum += $hiddenOutputs[$j] * $this->outputWeights[$j][$i];
            }
            $sum += $this->outputBias[$i]; // Menambahkan bias
            $outputInputs[$i] = $sum; // Menyimpan input pada lapisan keluaran
        }
        // Menggunakan fungsi aktivasi sigmoid untuk menghitung keluaran final
        $outputs = [];
        for ($i = 0; $i < $this->outputNeurons; $i++) {
            $outputs[$i] = $this->sigmoid($outputInputs[$i]);
        }
        return $outputs;
    }

    public function backpropagation($inputs, $targets, $learningRate)
    {
        $hiddenOutputs = [];
        $outputInputs = [];

        // Perhitungan output pada lapisan tersembunyi
        for ($i = 0; $i < $this->hiddenNeurons; $i++) {
            $sum = 0;
            for ($j = 0; $j < $this->inputNeurons; $j++) {
                // Mengalikan input dengan bobot dan menjumlahkannya
                $sum += $inputs[$j] * $this->hiddenWeights[$j][$i];
            }
            $sum += $this->hiddenBias[$i]; // Menambahkan bias
            $hiddenOutputs[$i] = $this->relu($sum);
        }

        // Perhitungan input pada lapisan keluaran
        for ($i = 0; $i < $this->outputNeurons; $i++) {
            $sum = 0;
            for ($j = 0; $j < $this->hiddenNeurons; $j++) {
                // Mengalikan output lapisan tersembunyi dengan bobot dan menjumlahkannya
                $sum += $hiddenOutputs[$j] * $this->outputWeights[$j][$i];
            }
            $sum += $this->outputBias[$i]; // Menambahkan bias
            $outputInputs[$i] = $sum;
        }
        // Menggunakan fungsi aktivasi sigmoid untuk menghitung keluaran final
        $outputs = [];
        for ($i = 0; $i < $this->outputNeurons; $i++) {
            $outputs[$i] = $this->sigmoid($outputInputs[$i]);
        }

        // Perhitungan delta pada lapisan keluaran
        $outputDeltas = [];
        for ($i = 0; $i < $this->outputNeurons; $i++) {
            $error = $targets[$i] - $outputs[$i];
            $outputDeltas[$i] = $error * $this->sigmoidDerivative($outputs[$i]);
        }

        // Perhitungan delta pada lapisan tersembunyi
        $hiddenDeltas = [];
        for ($i = 0; $i < $this->hiddenNeurons; $i++) {
            $error = 0;
            for ($j = 0; $j < $this->outputNeurons; $j++) {
                // Mengalikan delta lapisan keluaran dengan bobot dan menjumlahkannya
                $error += $outputDeltas[$j] * $this->outputWeights[$i][$j];
            }
            $hiddenDeltas[$i] = $error * $this->reluDerivative($hiddenOutputs[$i]);
        }

        // Perbarui bobot pada lapisan keluaran
        for ($i = 0; $i < $this->hiddenNeurons; $i++) {
            for ($j = 0; $j < $this->outputNeurons; $j++) {
                // Menghitung perubahan bobot dan memperbarui bobot
                $change = $outputDeltas[$j] * $hiddenOutputs[$i];
                $this->outputWeights[$i][$j] += $learningRate * $change;
            }
        }

        // Perbarui bobot pada lapisan tersembunyi
        for ($i = 0; $i < $this->inputNeurons; $i++) {
            for ($j = 0; $j < $this->hiddenNeurons; $j++) {
                // Menghitung perubahan bobot dan memperbarui bobot
                $change = $hiddenDeltas[$j] * $inputs[$i];
                $this->hiddenWeights[$i][$j] += $learningRate * $change;
            }
        }

        // Perbarui bias pada lapisan tersembunyi
        for ($i = 0; $i < $this->hiddenNeurons; $i++) {
            // Menghitung perubahan bias dan memperbarui bias
            $this->hiddenBias[$i] += $learningRate * $hiddenDeltas[$i];
        }

        // Perbarui bias pada lapisan keluaran
        for ($i = 0; $i < $this->outputNeurons; $i++) {
            // Menghitung perubahan bias dan memperbarui bias
            $this->outputBias[$i] += $learningRate * $outputDeltas[$i];
        }
    }
    public function train($trainingData, $epochs, $learningRate)
    {
        for ($epoch = 0; $epoch < $epochs; $epoch++) {
            $errorSum = 0;
            $mseSum = 0;

            foreach ($trainingData as $data) {
                $inputs = array_slice($data, 0, $this->inputNeurons);
                $targets = array_slice($data, $this->inputNeurons);

                $this->backpropagation($inputs, $targets, $learningRate);

                $error = 0;
                $outputs = $this->feedForward($inputs);
                for ($i = 0; $i < $this->outputNeurons; $i++) {
                    $error += abs($targets[$i] - $outputs[$i]);
                }
                $errorSum += $error;

                // Perhitungan MSE
                $mse = 0;
                for ($i = 0; $i < $this->outputNeurons; $i++) {
                    $mse += ($targets[$i] - $outputs[$i]) ** 2;
                }
                $mseSum += $mse;
            }

            // Menghitung rata-rata error dan MSE
            $averageError = $errorSum / count($trainingData);
            $averageMSE = $mseSum / (2 * count($trainingData));

            //menyimpan data hasil pelatihan setiap epoch kedalam array
            $trainingResults[]=[
                'epoch' => ($epoch+1),
                'averageError' => $averageError,
                'averageMSE' => $averageMSE,
                'hiddenWeights' => $this->hiddenWeights,
                'hiddenBias' => $this->hiddenBias,
                'ouputWeights' => $this->outputWeights,
                'ouputBias' => $this->outputBias,
            ];

            // Menghentikan pelatihan jika mencapai tingkat kesalahan yang diinginkan
            if ($averageError < 0.01) {
                break;
            }
        }
        return $trainingResults;
    }
    public function saveParametersToJson($filename)
    {
        $data = [
            'hiddenWeights' => $this->hiddenWeights,
            'hiddenBias' => $this->hiddenBias,
            'outputWeights' => $this->outputWeights,
            'outputBias' => $this->outputBias
        ];

        $jsonString = json_encode($data, JSON_PRETTY_PRINT);
        file_put_contents($filename, $jsonString);
    }
    public function loadParametersFromJson($filename)
    {
        //function untuk memanggil data dari json dan digunakan untuk perhitungan
        $jsonData = file_get_contents($filename);
        $data = json_decode($jsonData, true);

        if (isset($data['hiddenWeights'])) {
            $this->hiddenWeights = $data['hiddenWeights'];
        }

        if (isset($data['hiddenBias'])) {
            $this->hiddenBias = $data['hiddenBias'];
        }

        if (isset($data['outputWeights'])) {
            $this->outputWeights = $data['outputWeights'];
        }

        if (isset($data['outputBias'])) {
            $this->outputBias = $data['outputBias'];
        }
    }

    public function feedForwardTest($normalizedAttributes, $out, $hide, $filePath, $inputNeurons)
    {
        $jsonData = file_get_contents($filePath);
        $files = json_decode($jsonData, true);
        $hiddenWeights = $files['hiddenWeights'];
        $outputWeights = $files['outputWeights'];
        $hiddenBias = $files['hiddenBias'];
        $outputBias = $files['outputBias'];
        $hiddenOutputs = [];
        $outputInputs = [];

        // Perhitungan output pada lapisan tersembunyi
        for ($i = 0; $i < $hide; $i++) {
            $sum = 0;
            for ($j = 0; $j < $inputNeurons; $j++) {
                $sum += $normalizedAttributes[$j] * $hiddenWeights[$j][$i];
            }
            $sum += $hiddenBias[$i]; // Menambahkan bias
            $hiddenOutputs[$i] = $this->relu($sum);
        }

        // Perhitungan input pada lapisan keluaran
        for ($i = 0; $i < $out; $i++) {
            $sum = 0;
            for ($j = 0; $j < $hide; $j++) {
                $sum += $hiddenOutputs[$j] * $outputWeights[$j][$i];
            }
            $sum += $outputBias[$i]; // Menambahkan bias
            $outputInputs[$i] = $sum;
        }

        $outputs = [];
        for ($i = 0; $i < $out; $i++) {
            $outputs[$i] = $this->sigmoid($outputInputs[$i]);
        }
        return $outputs;
    }
}
