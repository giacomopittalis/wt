<?php

/**
 * Feeds Model
 * 
 * @author 		Sandi Andrian / andrian.sandi@gmail.com
 * @since 		Sep 30, 2014
 **/

 class Feed extends Eloquent
 {
 	protected $table = "feeds";
 	protected $fillable = array("user_id",
 								"ftype",
 								"fcomment");
 }