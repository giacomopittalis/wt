<?php

/**
 * Well Credit Consult Model
 * 
 * @author 		Sandi Andrian / andrian.sandi@gmail.com
 * @since 		Sep 30, 2014
 **/

 class WellCreditConsult extends Eloquent
 {
 	protected $table = "well_credit_consult";
 	protected $fillable = array("client_id",
 								"location_id",
 								"employee_id",
 								"comment");
 }