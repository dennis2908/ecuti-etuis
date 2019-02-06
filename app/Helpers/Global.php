<?php

function decimalToRinggit($num){
	$decones = array(
		'01' => "Satu",
		'02' => "Dua",
		'03' => "Tiga",
		'04' => "Empat",
		'05' => "Lima",
		'06' => "Enam",
		'07' => "Tujuh",
		'08' => "Lapan",
		'09' => "Sembilan",
		10 => "Sepuluh",
		11 => "Sebelas",
		12 => "Dua Belas",
		13 => "Tiga Belas",
		14 => "Empas Belas",
		15 => "Lima Belas",
		16 => "Enam Belas",
		17 => "Tujuh Belas",
		18 => "Lapan Belas",
		19 => "Sembilan Belas"
	);
	$ones = array(
		0 => " ",
		1 => "Satu",
		2 => "Dua",
		3 => "Tiga",
		4 => "Empat",
		5 => "Lima",
		6 => "Enam",
		7 => "Tujuh",
		8 => "Lapan",
		9 => "Sembilan",
		10 => "Sepuluh",
		11 => "Sebelas",
		12 => "Dua Belas",
		13 => "Tiga Belas",
		14 => "Empat Belas",
		15 => "Lima Belas",
		16 => "Enam Belas",
		17 => "Tujuh Belas",
		18 => "Lapan Belas",
		19 => "Sembilan Belas"
	);
	$tens = array(
		0 => "",
		2 => "Dua Puluh",
		3 => "Tiga Puluh",
		4 => "Empat Puluh",
		5 => "Lima Puluh",
		6 => "Enam Puluh",
		7 => "Tujuh Puluh",
		8 => "Lapan Puluh",
		9 => "Sembilan Puluh"
	);

	$hundreds = array(
		"Ratus",
		"Ribu",
		"Juta",
		"Bilion",
		"Trilion",
		"Quadrillion"
    ); //limit t quadrillion

	$num = number_format($num,2,".",",");
	$num_arr = explode(".",$num);
	$wholenum = $num_arr[0];
	$decnum = $num_arr[1];
	$whole_arr = array_reverse(explode(",",$wholenum));
	krsort($whole_arr);
	$rettxt = "";
	foreach($whole_arr as $key => $i){
		if((int)$i < 20){
			$rettxt .= $ones[(int)$i];
		}
		elseif((int)$i < 100){
			$rettxt .= $tens[(int)substr($i,0,1)];
			$rettxt .= " ".$ones[(int)substr($i,1,1)];
		}
		else{
			$rettxt .= $ones[(int)substr($i,0,1)]." ".$hundreds[0];
			$rettxt .= " ".$tens[(int)substr($i,1,1)];
			$rettxt .= " ".$ones[(int)substr($i,2,1)];
		}
		if($key > 0){
			$rettxt .= " ".$hundreds[$key]." ";
		}

	}
	$rettxt = $rettxt." Ringgit";

	if($decnum > 0){
		$rettxt .= " dan ";
		if($decnum < 20){
			$rettxt .= $decones[$decnum];
		}
		elseif($decnum < 100){
			$rettxt .= $tens[substr($decnum,0,1)];
			$rettxt .= " ".$ones[substr($decnum,1,1)];
		}
		$rettxt = $rettxt." Sen";
	}
	return strtolower($rettxt);
}

function numberToWords($num){
	$ones = array(
		0 => " ",
		1 => "Satu",
		2 => "Dua",
		3 => "Tiga",
		4 => "Empat",
		5 => "Lima",
		6 => "Enam",
		7 => "Tujuh",
		8 => "Lapan",
		9 => "Sembilan",
		10 => "Sepuluh",
		11 => "Sebelas",
		12 => "Dua Belas",
		13 => "Tiga Belas",
		14 => "Empat Belas",
		15 => "Lima Belas",
		16 => "Enam Belas",
		17 => "Tujuh Belas",
		18 => "Lapan Belas",
		19 => "Sembilan Belas"
	);
	$tens = array(
		0 => "",
		2 => "Dua Puluh",
		3 => "Tiga Puluh",
		4 => "Empat Puluh",
		5 => "Lima Puluh",
		6 => "Enam Puluh",
		7 => "Tujuh Puluh",
		8 => "Lapan Puluh",
		9 => "Sembilan Puluh"
	);

	$hundreds = array(
		"Ratus",
		"Ribu",
		"Juta",
		"Bilion",
		"Trilion",
		"Quadrillion"
    ); //limit t quadrillion

	$num = number_format($num,2,".",",");
	$num_arr = explode(".",$num);
	$wholenum = $num_arr[0];
	$decnum = $num_arr[1];
	$whole_arr = array_reverse(explode(",",$wholenum));
	krsort($whole_arr);
	$rettxt = "";
	foreach($whole_arr as $key => $i){
		if((int)$i < 20){
			$rettxt .= $ones[(int)$i];
		}
		elseif((int)$i < 100){
			$rettxt .= $tens[(int)substr($i,0,1)];
			$rettxt .= " ".$ones[(int)substr($i,1,1)];
		}
		else{
			$rettxt .= $ones[(int)substr($i,0,1)]." ".$hundreds[0];
			$rettxt .= " ".$tens[(int)substr($i,1,1)];
			$rettxt .= " ".$ones[(int)substr($i,2,1)];
		}
		if($key > 0){
			$rettxt .= " ".$hundreds[$key]." ";
		}

	}
	return strtolower($rettxt);
}

function checkCaps($key, $value) {
	if(strtoupper($key) == $key)
		return strtoupper($value);
	else if( strtolower($key) == $key)
		return strtolower($value);
	else
		return ucwords(strtolower($value));
}

function letterButton($letter_type_id, $filing_type, $filing_id) {

	$letter = \App\OtherModel\Letter::query();

	$letter = $letter->where('letter_type_id', $letter_type_id)->where('filing_type', $filing_type)->where('filing_id', $filing_id)->get();

	if($letter->count() > 0) {
		$letter = $letter->first();

		if(auth()->user()->user_type_id > 2) {
			// Download button
			if($letter->attachment) {
				return '<a href="'.route('general.getAttachment', [$letter->attachment->id, $letter->attachment->name] ).'" class="btn btn-default btn-xs mb-1 text-success" data-toggle="tooltip" data-placement="top" title="Muat Turun Surat"><i class="fa fa-download mr-1"></i> '.$letter->type->name.'</a><br>';
			}
			else
				return '';
		}
		else {
			// Edit button
			return '<a href="'.route('letter.item', $letter->id).'" class="btn btn-default btn-xs mb-1 '.($letter->attachment ? 'text-success' : '').'" data-toggle="tooltip" data-placement="top" title="Kemaskini Surat"><i class="fa fa-edit mr-1"></i> '.$letter->type->name.'</a><br>';
		}
	}
	else {
		// Create button
		$filing = $filing_type::findOrFail($filing_id);
		$module = \App\MasterModel\MasterLetterType::findOrFail($letter_type_id)->module;

		$letter = \App\OtherModel\Letter::create([
			'letter_type_id' => $letter_type_id,
			'module_id' => $module->id,
			'filing_type' => $filing_type,
			'filing_id' => $filing_id,
			'entity_type' => isset($filing->entity_type) ? $filing->entity_type : $filing->created_by->entity_type,
			'entity_id' => isset($filing->entity_id) ? $filing->entity_id : $filing->created_by->entity_id,
			'created_by_user_id' => auth()->id(),
		]);

		return '<a href="'.route('letter.item', $letter->id).'" class="btn btn-default btn-xs mb-1" data-toggle="tooltip" data-placement="top" title="Jana Surat"><i class="fa fa-file-text mr-1"></i> '.$letter->type->name.'</a><br>';
	}

}

function fullUrl() {
	if (strpos(env('APP_URL'), 'https://') !== false)
        return str_replace('http://', 'https://', request()->fullUrl());
    else
    	return request()->fullUrl();
}

function previousUrl() {
	if (strpos(env('APP_URL'), 'https://') !== false)
        return str_replace('http://', 'https://', url()->previous());
    else
    	return url()->previous();
}

function nextWorkingDay($filing, $start_date, $days = 1) {
	
	$start_date = \Carbon\Carbon::parse($start_date);
	$end_date = $start_date->addDays($days);

	$holidays = \App\OtherModel\Holiday::whereIn(DB::raw('YEAR(start_date)'), [$start_date->subYear()->year, $start_date->addYear()->year])
		->where(function($holidays) use($filing) {
			return $holidays->whereNotNull('holiday_type_id')->orWhereHas('states', function($states) use($filing) {
				return $states->where('state_id', $filing->created_by->entity->province_office->state_id);
			});
		})
		->get();

	$dates = [];
	foreach($holidays as $holiday) {
		$period = \Carbon\CarbonPeriod::create($holiday->start_date, $holiday->duration);

		foreach($period as $date) {
			// if this date between or equals
			if( $date->between($start_date, $end_date) )
				array_push($dates, $date->toDateString());
		}
	}

	$end_date = $end_date->addDays(count($dates));

	// If weekend
	if( $filing->created_by->entity->province_office->address->state->is_friday_weekend ) {
		// 5 or 6
		if($end_date->dayOfWeek == 5)
			$end_date = $end_date->addDays(2);
		else if($end_date->dayOfWeek == 6)
			$end_date = $end_date->addDays(1);
	}
	else {
		// 6 or 7
		if($end_date->dayOfWeek == 6)
			$end_date = $end_date->addDays(2);
		else if($end_date->dayOfWeek == 7)
			$end_date = $end_date->addDays(1);
	}

	while(in_array($end_date->toDateString(), $dates)) {
		$end_date = $end_date->addDays(1);
	}

	return $end_date;
}