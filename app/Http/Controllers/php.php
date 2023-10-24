<?php
function sigmoid($x)
{
    return 1 / (1 + exp(-$x));
}
public function trainAndSaveWeights()
{
    $inputNeurons = 7;
    $hiddenNeurons = 20;
    $outputNeurons = 1;
    $learningRate = 0.01;
    $epochs = 1500;

    $datasetPath = resource_path('csv/fix_lagi.csv');
    $dataset = file($datasetPath);
    $datas =[];

    [$weightsHidden, $weightsOutput, $biasHidden, $biasOutput] = $this->__construct($inputNeurons, $hiddenNeurons, $outputNeurons, $learningRate, $epochs);

    for ($epoch = 0; $epoch < $epochs; $epoch++) {
        foreach ($dataset as $data) {
            // Ambil atribut input dan output target dari dataset
            $line = str_getcsv($data);
            $datas[] = array_map('floatval', $line);
            $inputs = array_slice($datas, 0, $inputNeurons);
            $targets = array_slice($datas, $inputNeurons);

            // Lakukan feedforward
            [$hiddenLayer, $outputLayer] = $this->feedforward($inputNeurons, $weightsHidden, $weightsOutput, $biasHidden, $biasOutput, $inputs);

            // Lakukan backpropagation
            [$weightsHidden, $weightsOutput, $biasHidden, $biasOutput] = $this->backpropagation($inputs, $targets, $hiddenLayer, $outputLayer, $weightsHidden, $weightsOutput, $biasHidden, $biasOutput, $learningRate);
        }
    }

    $this->saveWeightsToJson($weightsHidden, $weightsOutput, $biasHidden, $biasOutput);

    return redirect()->back()->with('success', 'Proses pelatihan berhasil! Bobot dan bias terakhir disimpan dalam JSON.');
}
protected function loadDataset($filename)
{
    $csvFile = file($filename);
    $dataset = [];
    foreach ($csvFile as $line) {
        $data = str_getcsv($line);
        $dataset[] = array_map('floatval', $data); // Ubah data menjadi float
    }
    return $dataset;
}

protected $inputNeurons;
protected $hiddenNeurons;
protected $outputNeurons;
protected $learningRate;
protected $epochs;
protected $hiddenWeights;
protected $hiddenBias; // Bias pada lapisan tersembunyi
protected $outputWeights;
protected $outputBias; // Bias pada lapisan output
public function getHiddenWeights()
{
    return $this->hiddenWeights;
}

public function getHiddenBias()
{
    return $this->hiddenBias;
}

public function getOutputWeights()
{
    return $this->outputWeights;
}

public function getOutputBias()
{
    return $this->outputBias;
}   

public function __construct($inputNeurons='7', $hiddenNeurons='20', $outputNeurons='1', $learningRate='0.01', $epochs='1500')
{
    $this->inputNeurons = $inputNeurons;
    $this->hiddenNeurons = $hiddenNeurons;
    $this->outputNeurons = $outputNeurons;
    $this->learningRate = $learningRate;
    $this->epochs = $epochs;

   // Inisialisasi bobot dan bias secara acak antara -1 dan 1
   $this->hiddenWeights = [];
   $this->hiddenBias = [];
   for ($i = 0; $i < $this->inputNeurons; $i++) {
       for ($j = 0; $j < $this->hiddenNeurons; $j++) {
           $this->hiddenWeights[$i][$j] = (2 * (mt_rand() / mt_getrandmax())) - 1;
       }
   }
   for ($i = 0; $i < $this->hiddenNeurons; $i++) {
       $this->hiddenBias[$i] = (2 * (mt_rand() / mt_getrandmax())) - 1;
   }

   $this->outputWeights = [];
   $this->outputBias = [];
   for ($i = 0; $i < $this->hiddenNeurons; $i++) {
       for ($j = 0; $j < $this->outputNeurons; $j++) {
           $this->outputWeights[$i][$j] = (2 * (mt_rand() / mt_getrandmax())) - 1;
       }
   }
   for ($i = 0; $i < $this->outputNeurons; $i++) {
       $this->outputBias[$i] = (2 * (mt_rand() / mt_getrandmax())) - 1;
   }
}

// Fungsi feedforward
public function feedForward($inputs)
{
    $hiddenOutputs = [];
    $outputInputs = [];

    // Perhitungan output pada lapisan tersembunyi
    for ($i = 0; $i < $this->hiddenNeurons; $i++) {
        $sum = 0;   
        for ($j = 0; $j < $this->inputNeurons; $j++) {
            $sum += $inputs[$j] * $this->hiddenWeights[$j][$i];
        }
        $sum += $this->hiddenBias[$i]; // Menambahkan bias
        $hiddenOutputs[$i] = $this->sigmoid($sum);
    }

    // Perhitungan input pada lapisan keluaran
    for ($i = 0; $i < $this->outputNeurons; $i++) {
        $sum = 0;
        for ($j = 0; $j < $this->hiddenNeurons; $j++) {
            $sum += $hiddenOutputs[$j] * $this->outputWeights[$j][$i];
        }
        $sum += $this->outputBias[$i]; // Menambahkan bias
        $outputInputs[$i] = $sum;
    }

    $outputs = [];
    for ($i = 0; $i < $this->outputNeurons; $i++) {
        $outputs[$i] = $this->sigmoid($outputInputs[$i]);
    }

    return $outputs;
}
// fungsi backpropagation
public function backpropagation($inputs, $targets)
{
    $hiddenOutputs = [];
    $outputInputs = [];

    // Perhitungan output pada lapisan tersembunyi
    for ($i = 0; $i < $this->hiddenNeurons; $i++) {
        $sum = 0;
        for ($j = 0; $j < $this->inputNeurons; $j++) {
            $sum += $inputs[$j] * $this->hiddenWeights[$j][$i];
        }
        $sum += $this->hiddenBias[$i]; // Menambahkan bias
        $hiddenOutputs[$i] = $this->sigmoid($sum);
    }

    // Perhitungan input pada lapisan keluaran
    for ($i = 0; $i < $this->outputNeurons; $i++) {
        $sum = 0;
        for ($j = 0; $j < $this->hiddenNeurons; $j++) {
            $sum += $hiddenOutputs[$j] * $this->outputWeights[$j][$i];
        }
        $sum += $this->outputBias[$i]; // Menambahkan bias
        $outputInputs[$i] = $sum;
    }

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
            $error += $outputDeltas[$j] * $this->outputWeights[$i][$j];
        }
        $hiddenDeltas[$i] = $error * $this->sigmoidDerivative($hiddenOutputs[$i]);
    }

    // Perbarui bobot pada lapisan keluaran
    for ($i = 0; $i < $this->hiddenNeurons; $i++) {
        for ($j = 0; $j < $this->outputNeurons; $j++) {
            $change = $outputDeltas[$j] * $hiddenOutputs[$i];
            $this->outputWeights[$i][$j] += $this->learningRate * $change;
        }
    }

    // Perbarui bobot pada lapisan tersembunyi
for ($i = 0; $i < $this->inputNeurons; $i++) {
    for ($j = 0; $j < $this->hiddenNeurons; $j++) {
        $change = $hiddenDeltas[$j] * $inputs[$i];
        $this->hiddenWeights[$i][$j] += $this->learningRate * $change;
    }
}

// Perbarui bias pada lapisan tersembunyi
for ($i = 0; $i < $this->hiddenNeurons; $i++) {
    $this->hiddenBias[$i] += $this->learningRate * $hiddenDeltas[$i];
}

// Perbarui bias pada lapisan keluaran
for ($i = 0; $i < $this->outputNeurons; $i++) {
    $this->outputBias[$i] += $this->learningRate * $outputDeltas[$i];
}
}


// Fungsi pelatihan
public function train($trainingData)
{
    for ($epoch = 0; $epoch < $this->epochs; $epoch++) {
        $errorSum = 0;
        $mseSum = 0;

        foreach ($trainingData as $data) {
            $inputs = array_slice($data, 0, $this->inputNeurons);
            $targets = array_slice($data, $this->inputNeurons);

            $this->backpropagation($inputs, $targets);

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

        // Menampilkan progress pelatihan, bobot, bias, dan hasil output
        echo "Epoch: " . ($epoch + 1) . " - Error: " . $averageError . " - MSE: " . $averageMSE . "\n";

         echo "Hidden Weights:\n";
        for ($i = 0; $i < $this->inputNeurons; $i++) {
            for ($j = 0; $j < $this->hiddenNeurons; $j++) {
                echo $this->hiddenWeights[$i][$j] . " ";
            }
            echo "\n";
        }

        echo "Hidden Bias:\n";
        for ($i = 0; $i < $this->hiddenNeurons; $i++) {
            echo $this->hiddenBias[$i] . " ";
        }
        echo "\n";

        echo "Output Weights:\n";
        for ($i = 0; $i < $this->hiddenNeurons; $i++) {
            for ($j = 0; $j < $this->outputNeurons; $j++) {
                echo $this->outputWeights[$i][$j] . " ";
            }
            echo "\n";
        }

        echo "Output Bias:\n";
        for ($i = 0; $i < $this->outputNeurons; $i++) {
            echo $this->outputBias[$i] . " ";
        }
        echo "\n";
        // Menghentikan pelatihan jika mencapai tingkat kesalahan yang diinginkan
        if ($averageError < 0.01) {
            break;
        }
    }
    
}
public function saveParametersToJson($filename) {
    $data = [
        'hiddenWeights' => $this->hiddenWeights,
        'hiddenBias' => $this->hiddenBias,
        'outputWeights' => $this->outputWeights,
        'outputBias' => $this->outputBias
    ];

    $jsonString = json_encode($data, JSON_PRETTY_PRINT);
    file_put_contents(resource_path('json/parameters.json'), $jsonString);
}


// Fungsi turunan sigmoid
function sigmoidDerivative($x)
{
    return $x * (1 - $x);
}

    public function predict(Request $request){ 
        // Contoh penggunaan model untuk mendiagnosa penyakit
        $inputs = 
            [0.27, 0, 0, 0.001, 0.0000201, 0.138, 0.091]; // Contoh input
            [$hiddenLayer, $outputLayer] = $this->feedforward($inputs);

        $diagnosis = $outputLayer[0] >= 0.5 ? 'Ya' : 'Tidak';

        echo "Hasil Diagnosa: " . $diagnosis[0] . "\n" . "Hasil angka diagnosa: " . $diagnosis;
    
    }
    public function getFinalWeights()
    {
        // Ambil bobot terakhir dari model (misalnya dari file .json atau database)
        // Gantilah 'parameters.json' dengan nama file atau metode yang sesuai dengan penyimpanan bobot Anda
        $filePath = resource_path('json/parameters.json');
        $file = file_get_contents($filePath);
        $parameters = json_decode($file, true);

        // Ambil bobot dari parameter yang telah disimpan
        $weightsInputHidden = $parameters['hiddenWeights'];
        $weightsHiddenOutput = $parameters['outputWeights'];
        $biasHidden = $parameters['hiddenBias'];
        $biasOutput = $parameters['outputBias'];

         $totalWeights = count($weightsInputHidden) * count($weightsInputHidden[0])
                                    + count($weightsHiddenOutput) * count($weightsHiddenOutput[0])
                                    + count($biasHidden)
                                    + count($biasOutput);
                    $percentage = ($totalWeights / 599) * 100; // Anggap total bobot 700 sebagai contoh
        // Tampilkan bobot terakhir
        return view('admin.backpropagation', compact('weightsInputHidden', 'weightsHiddenOutput', 'biasHidden', 'biasOutput', 'percentage'));
    }

?>
