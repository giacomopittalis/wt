<?php

/**
 * Proactive Consult Model
 * 
 * @author 		Sandi Andrian / andrian.sandi@gmail.com
 * @since 		Sep 30, 2014
 **/

 class ProactiveConsult extends Eloquent
 {
 	protected $table = "proactive_consult";
 	protected $fillable = array("client_id",
 								"location_id",
 								"employee_id",
 								"under_medical_care",
 								"comment",
 								"follow_up",
 								"notes");
 }