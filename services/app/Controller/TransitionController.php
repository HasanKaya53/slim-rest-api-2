<?php

namespace App\Controller;


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


    public function createNewTransition($request, $response, $args)
    {
        $data = $request->getParsedBody();
        $data = json_decode(json_encode($data), true);

        $plaka = $data['plaka'] ?: null;
        $tarih = $data['tarih'] ?: null;




        $response->getBody()->write(json_encode(['status' => true, 'data' => $this->isValidLicensePlate($plaka), 'date' => $this->isValidDate($tarih)]));

        return $response;


    }

}