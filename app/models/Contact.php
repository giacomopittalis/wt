<?php

/**
 * Contact Model
 * 
 * @author 		Sandi Andrian / andrian.sandi@gmail.com
 * @since 		Sep 30, 2014
 **/

 class Contact extends Eloquent
 {
 	protected $table = "contacts";
 	protected $fillable = array("mode",
 								"method",
 								"start",
 								"client_id",
 								"location_id",
 								"employee_id");
 }