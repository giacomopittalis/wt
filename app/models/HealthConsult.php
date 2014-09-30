<?php

/**
 * Health Consult Model
 * 
 * @author 		Sandi Andrian / andrian.sandi@gmail.com
 * @since 		Sep 30, 2014
 **/

 class HealthConsult extends Eloquent
 {
 	protected $table = "health_consult";
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