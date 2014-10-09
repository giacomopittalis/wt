<?php

/**
 * Employee Model
 * 
 * @author 		Sandi Andrian / andrian.sandi@gmail.com
 * @since 		Sep 30, 2014
 **/

 class Employee extends Eloquent
 {
 	protected $table = "employees";
 	protected $fillable = array("first_name",
 								"middle_name",
 								"last_name",
 								"sex",
 								"dob",
 								"department",
 								"position",
 								"hire_year",
 								"hire_type",
 								"health_plan",
 								"image",
 								"client_id",
 								"location_id");
 }