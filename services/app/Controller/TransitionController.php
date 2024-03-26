<?php

namespace App\Controller;

use App\Model\PlateModel;
use App\Model\TransitionModel;

class TransitionController
{

    function isValidLicensePlate($plateNumber) {

        $pattern = '/^\d{2}\s?[A-Z]{1,3}\s?\d{4}$/';

        if (preg_match($pattern, $plateNumber)) {
            return true; // Geçerli bir plaka numarası
        } else {
            return false; // Geçersiz plaka numarası
        }
    }

    function isValidDate($date) {
        $pattern = '/^\d{4}-\d{2}-\d{2}$/';
        if (preg_match($pattern, $date)) {
            list($year, $month, $day) = explode('-', $date);
            if (checkdate($month, $day, $year)) {
                return true; // Geçerli bir tarih
            }
        }
        return false; // Geçersiz tarih
    }

    function isValidDateTime($datetime) {
        // Tarih ve saat formatını kontrol etmek için düzenli ifade
        $pattern = '/^\d{4}-\d{2}-\d{2} \d{2}:\d{2}:\d{2}$/';

        // Tarih ve saat formatının doğruluğunu kontrol et
        if (preg_match($pattern, $datetime)) {
            // Tarih ve saat bilgisini ayrıştır
            list($date, $time) = explode(' ', $datetime);

            // Tarih kontrolü
            if ($this->isValidDate($date)) {
                // Saat kontrolü
                list($hour, $minute, $second) = explode(':', $time);
                if ($hour >= 0 && $hour < 24 && $minute >= 0 && $minute < 60 && $second >= 0 && $second < 60) {
                    return true; // Geçerli tarih ve saat
                }
            }
        }
        return false; // Geçersiz tarih ve saat
    }


    public function createNewTransition($request, $response, $args)
    {
        $data = $request->getParsedBody();
        $data = json_decode(json_encode($data), true);


        $plaka = $data['plaka'] ?: null;
        $tarih = $data['tarih'] ?: null;



        if (!$this->isValidLicensePlate(strtoupper($plaka))) {
            $response->getBody()->write(json_encode(['status' => false, 'error' => 'Geçersiz plaka numarası']));
            return $response;
        }

        if (!$this->isValidDateTime($tarih)) {
            $response->getBody()->write(json_encode(['status' => false, 'error' => 'Geçersiz tarih']));
            return $response;
        }

        if (strtotime($tarih) > strtotime(date('Y-m-d H:i:s'))) {
            $response->getBody()->write(json_encode(['status' => false, 'error' => 'Geçiş tarihi bugünden ileri bir tarih olamaz']));
            return $response;
        }

        $tarih = date('Y-m-d H:i:s', strtotime($tarih));
        $plaka = strtoupper(str_replace(' ', '', $plaka));
        //upper.


        $plateModel = new PlateModel();
        $transitionModel = new TransitionModel();
        //check if plate exists
        $plate = $plateModel->getPlate($plaka);

        if (count($plate) == 0) {
            $plateID = $plateModel->createNewPlate(['plate' => $plaka]);
        }else{
            $plateID = $plate[0]['id'];
        }




        $checkTransition = $transitionModel->searchTransition($plateID, $tarih);

        if(count($checkTransition) > 0){
            $response->getBody()->write(json_encode(['status' => false, 'error' => 'Bu plaka ve tarih için daha önce geçiş yapılmış']));
            return $response;
        }

        if ($plateID == 0) {
            $response->getBody()->write(json_encode(['status' => false, 'error' => 'Plaka oluşturulamadı']));
            return $response;
        }


        $searchData = date('Y-m-d', strtotime($tarih));

        $total = $transitionModel->carTodayTotal($plateID,$searchData);


        $price = 10;
        if($total[0]['total'] == 1){
            // %50 indirim
            $price = $price * 0.5;
        }else if($total[0]['total'] > 1){
            // %25 indirim
            $price = 0;
        }



        $transitionID = $transitionModel->createNewTransition(['plate_id' => $plateID,'price' => $price, 'date' => $tarih]);

        if ($transitionID == 0) {
            $response->getBody()->write(json_encode(['status' => false, 'error' => 'Geçiş oluşturulamadı']));
            return $response;
        }

        $response->getBody()->write(json_encode(['status' => true, 'message' => 'Geçiş başarılı', 'price' => $price]));
        return $response;
    }


    public function listTransition($request, $response, $args)
    {
        $transitionModel = new TransitionModel();
        $transitions = $transitionModel->listAllTransition();

        $response->getBody()->write(json_encode($transitions));


        return $response;
    }

}