<?php

/**
 * User Profile Component Model
 * 
 * @author 		Sandi Andrian / andrian.sandi@gmail.com
 * @since 		Oct 4, 2014
 **/

 class UserProfileComponent extends Eloquent
 {
 	protected $table = "users_profile_components";
 	protected $fillable = array("user_id",
 								"name",
 								"value");
 }