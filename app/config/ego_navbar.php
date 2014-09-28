<?php
	return array(
		'class'=>"navbar",
		'items'=>array(
				'ego_anax'=>array(
					'text'=>"EGO - ANAX",
					'url'=>"ego_anax",
					'title'=>"Huvudsidan"
					),
				'me'=>array(
					'text'=>"OM MIG",
					'url'=>"me",
					'title'=>"Om mig"
					),
				'test'=>array(
					'text'=>"REDOVISNINGAR",
					'url'=>"kmoms",
					'title'=>"Redovisningar",
					'submenu'=>array(
						'items'=>array(
							'item 1'=>array(
								'text'=>"Kmom01: PHP-baserade och MVC-inspirerade ramverk",
								'url'=>"kmom01",
								'title'=>"Kmom01: PHP-baserade och MVC-inspirerade ramverk"
								),
							'item 2'=>array(
								'text'=>"Kmom02: Kontroller och Modeller",
								'url'=>"kmom02",
								'title'=>"Kmom02: Kontroller och Modeller"
								),
							'item 3'=>array(
								'text'=>"Kmom03: Bygg ett eget tema",
								'url'=>"kmom03",
								'title'=>"Kmom03: Bygg ett eget tema"
								),
							'item 4'=>array(
								'text'=>"Kmom04: Databaser, ORM och scaffolding",
								'url'=>"kmom04",
								'title'=>"Kmom04: Databaser, ORM och scaffolding"
								),
							'item 5'=>array(
								'text'=>"Kmom05: Bygg ut ramverket",
								'url'=>"kmom05",
								'title'=>"Kmom05: Bygg ut ramverket"
								),
							'item 6'=>array(
								'text'=>"Kmom06: Verktyg och Continuous integration",
								'url'=>"kmom06",
								'title'=>"Kmom06: Verktyg och Continuous integration"
								),
							'item 7'=>array(
								'text'=>"Kmom07/10: Projekt/Examination",
								'url'=>"kmom07",
								'title'=>"Kmom07/10: Projekt/Examination"
								)
							)
						)
					),
				'source'=>array(
					'text'=>"KÄLLKOD",
					'url'=>"source",
					'title'=>"Kika på källkoden"
					),
				'calendar'=>array(
					'text'=>"KALENDER",
					'url'=>"calendar",
					'title'=>"Håll koll på tiden..."
					),
				/*
				'error404'=>array(
					'text'=>"ERROR 404",
					'url'=>"var_e_min_sida_?",
					'title'=>"Snabbtest av Error 404"
					),
					*/
				'ctrlTest'=>array(
					'text'=>"CTRL-TEST",
					'url'=>"ctrlTest",
					'title'=>"Test av kontroller"
					)
				),
			'callback'=>function($url) {
				if ($url==$this->di->get("request")->getRoute()) {
					return true;
				}
			},
			'create_url'=>function($url) {
				return $this->di->get("url")->create($url);
			}
			);
	
?>