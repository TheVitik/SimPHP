<?php
// METHOD - URI - VIEW - ACTION - ACCESS
return [
    ["method"=>"GET","uri"=>"/","view"=>"index"],
    ["method"=>"GET","uri"=>"/login","action"=>"AuthController/login","access"=>"guest"],
    ["method"=>"GET","uri"=>"/register","action"=>"AuthController/register","access"=>"guest"],
    ["method"=>"POST","uri"=>"/login","action"=>"AuthController/signin","access"=>"guest"],
    ["method"=>"POST","uri"=>"/register","action"=>"AuthController/signup","access"=>"guest"],
    ["method"=>"GET","uri"=>"/account","action"=>"AccountController/account","access"=>"user"],
    ["method"=>"GET","uri"=>"/logout","action"=>"AuthController/logout"],
    ["method"=>"GET","uri"=>"/create","action"=>"AccountController/create","access"=>"user"],
    ["method"=>"POST","uri"=>"/create","action"=>"AccountController/newApplication","access"=>"user"],
    ["method"=>"GET","uri"=>"/admin","action"=>"AdminController/admin","access"=>"admin"],
    ["method"=>"GET","uri"=>"/add","action"=>"AdminController/add","access"=>"admin"],
    ["method"=>"POST","uri"=>"/add","action"=>"AdminController/addDoctor","access"=>"admin"],
];