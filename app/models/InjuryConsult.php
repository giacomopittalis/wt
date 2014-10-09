<?php

/**
 * Injury Consult Model
 * 
 * @author 		Sandi Andrian / andrian.sandi@gmail.com
 * @since 		Oct 3, 2014
 **/

 class InjuryConsult extends Eloquent
 {
 	protected $table = "injury_consult";
 	protected $fillable = array("client_id",
 								"location_id",
 								"employee_id",
 								"under_medical_care",
 								"info",
 								"topics",
 								"soap",
 								"follow_up",
 								"notes");
 }