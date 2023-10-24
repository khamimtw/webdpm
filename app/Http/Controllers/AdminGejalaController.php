<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\ANN;
use App\Models\NormalizedData;
use Illuminate\Support\Facades\Session;

class AdminGejalaController extends Controller
{
    public function getFinalWeights()
    {
        // Mengambil data file json dari storage
        $filePath = storage_path('parameters.json');
        $file = file_get_contents($filePath);
        $parameters = json_decode($file, true);

        // Ambil bobot dari parameter yang telah disimpan
        $weightsInputHidden = $parameters['hiddenWeights'];
        $weightsHiddenOutput = $parameters['outputWeights'];
        $biasHidden = $parameters['hiddenBias'];
        $biasOutput = $parameters['outputBias'];
    
        //menghitung total bobot untuk dihitung presentasenya
        $totalWeights = count($weightsInputHidden) * count($weightsInputHidden[0])
            + count($weightsHiddenOutput) * count($weightsHiddenOutput[0])
            + count($biasHidden)
            + count($biasOutput);
        // Tampilan bobot terakhir
        return view('admin.backpropagation', compact('weightsInputHidden', 'weightsHiddenOutput', 'biasHidden', 'biasOutput'));
    }
    public function train()
    {
        $inputNeurons = 6; //jumplah input neuron
        $hiddenNeurons = 5; //jumlah hidden neuron
        $outputNeurons = 1; //jumlah output neuron
        $learningRate = 0.01; //learning rate
        $epochs = 300; //epoch yang dipakai

        $neuralNetwork = new ANN(); //memanggil models/ANN.php
        $neuralNetwork->initializeParameters($inputNeurons, $hiddenNeurons, $outputNeurons); //mengirim data input, hidden dan output neuron ke function

        $trainingData = []; // diisi dengan data latih dari CSV
        $filePath = resource_path('csv/data_latih_normalized.csv'); // memanggil file csv dari storage

        if (file_exists($filePath)) { 
            //memeriksa apakah file dengan path yang disimpan dalam variabel $filePath ada atau tidak.
            $file = fopen($filePath, "r"); 
            //ika file yang diinginkan ditemukan, maka kode ini membuka file tersebut untuk dibaca. 
            while (($data = fgetcsv($file, 1000, ",")) !== FALSE) {
            //loop while yang akan berjalan selama kondisi dalam tanda kurung () bernilai TRUE. Dalam konteks ini, kode ini akan terus berjalan selama fgetcsv berhasil membaca baris data dari file CSV. 
                $trainingData[] = array_map('floatval', $data);
            //Setiap kali sebuah baris data berhasil dibaca, kode ini akan mengkonversi setiap elemen data dalam baris tersebut menjadi tipe data float (bilangan desimal) menggunakan fungsi floatval.
            }
            fclose($file);
        }
        $trainingResults = $neuralNetwork->train($trainingData, $epochs, $learningRate); //menjalankan fungsi train yang ada di model ANN

        $neuralNetwork->saveParametersToJson('parameters2.json');
            //menyimpan hasil perhitungan bobot dan bias
            session()->put('trainingResults', $trainingResults);
        return redirect()->back()->with('success', 'Berhasil melakukan pelatihan metode backpropagation neural network');
    }
    public function diagnose(Request $request)
    {
        $out = 1; //output neuron
        $hide = 5; //hidden neuron
        $inputNeurons = 6; //input neuron
        $neuralNetwork = new ANN(); //memanggil model ANN
        $filePath = storage_path('parameters2.json'); //membaca file parameters.json 
        $neuralNetwork->loadParametersFromJson($filePath); // memproses bobot dan bias dalam file json agar dapat digunakan
       
        $correctPredictions = 0;
        
        if (file_exists($filePath)) {
            $file = fopen($filePath, "r");

            while (($data = fgetcsv($file, 1000, ",")) !== FALSE) {
                $trainingData[] = array_map('floatval', $data);
            }
            fclose($file);
        }
        $file = resource_path('csv/data_uji_normalized.csv'); //membaca dataset uji

        if ($file) {
            $csvData = file($file); // Baris ini membaca seluruh konten file ke dalam array $csvData.
            
            $header = str_getcsv(array_shift($csvData)); 
            // Baris ini mengambil baris pertama dari $csvData (yaitu, header) menggunakan array_shift(),dan kemudian mengkonversinya menjadi array dengan str_getcsv().
            
            $csvDatas = array_slice($csvData, 1); // Baris ini menghapus baris header dari $csvData dan menyimpan sisanya (data) dalam $csvDatas.
            
            $results = []; // Baris ini mendefinisikan array $results yang akan digunakan untuk menyimpan hasil pengolahan data.

            foreach ($csvDatas as $csvRow) {
                $attributes = str_getcsv($csvRow); 
                // Baris ini mengkonversi baris data saat ini menjadi array $attributes dengan str_getcsv().
        
                $result = $neuralNetwork->feedForwardTest($attributes, $out, $hide, $filePath, $inputNeurons); 
                // Baris ini memanggil metode feedForwardTest() pada objek $neuralNetwork dan menyediakan $attributes sebagai input.

                $hasil = $result[0] >= 0.5 ? 1 : 0 ; 
                // Baris ini melakukan pengecekan pada hasil $result.
                // Jika hasil pertama dalam $result lebih besar atau sama dengan 0.5, maka $hasil disetel sebagai 'Ya', jika tidak, maka 'Tidak'.
                $actual = $attributes[6];
                $isCorrect = $hasil == $actual;
                if ($isCorrect) {
                    $correctPredictions++;
                }

                $predict = $correctPredictions / count($csvDatas) * 100;
                $results[] =  ['attributes' => $attributes, 'result' => $result, 'hasil' => $hasil];
            }
            $resultsFilePath = storage_path('app/public/feedforward.json');
            // Baris ini menambahkan elemen baru ke dalam array $results.
            // Setiap elemen berisi array asosiatif dengan kunci 'attributes', 'result', dan 'hasil'.
    
            file_put_contents($resultsFilePath, json_encode($results));
            //menyimpan hasil pengolahan data ke dalam sebuah file dalam format JSON.
            
            return view('admin.feedForward', compact('results', 'hasil', 'header', 'predict'));
        }
        return redirect()->back()->with('error', 'No CSV file uploaded.');
    }
    public function normalizeData(Request $request)
    {
        // Validasi data inputan
        $validatedData = $request->validate([
            'data' => 'required|array',
        ]);

        // Proses normalisasi data
        $dataToNormalize = $request->input('data');
        $normalizedData = $this->minMaxNormalization($dataToNormalize);

        // Simpan data yang sudah dinormalisasi ke database
        foreach ($normalizedData as $normalizedRow) {
            NormalizedData::create([
                'umur' => $normalizedRow[0],
                'jenis_kelamin' => $normalizedRow[1],
                'kehamilan' => $normalizedRow[2],
                'TSH' => $normalizedRow[3],
                'T3' => $normalizedRow[4],
                'TT4' => $normalizedRow[5],
            ]);
        }
        // Redirect atau kirim respon
        return redirect()->back()->with('success', 'Data has been normalized and saved successfully.');
    }

    private function minMaxNormalization($data)
    {
        // Menghitung nilai minimum dan maximum untuk setiap kolom dari data
        $minVals = array_map('min', ...$data);
        $maxVals = array_map('max', ...$data);

        $normalizedData = [];
        // Iterasi melalui setiap baris data dalam $data
        foreach ($data as $row) {
            $normalizedRow = [];
            // Iterasi melalui setiap nilai dalam baris data
            foreach ($row as $i => $value) {
                // Normalisasi nilai saat ini menggunakan rumus (value - min) / (max - min)
                $normalizedRow[] = ($value - $minVals[$i]) / ($maxVals[$i] - $minVals[$i]);
            }
            // Menambahkan baris data yang telah dinormalisasi ke dalam $normalizedData
            $normalizedData[] = $normalizedRow;
        }

        return $normalizedData;
    }
}
