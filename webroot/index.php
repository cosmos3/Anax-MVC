<?php
	require(__DIR__."/config_with_app.php");
	
	include(ANAX_APP_PATH."config/ego_functions.php");

	$app->theme->configure(ANAX_APP_PATH."config/ego_theme.php");
	$app->navbar->configure(ANAX_APP_PATH."config/ego_navbar.php");
	
	$app->url->setUrlType(\Anax\Url\CUrl::URL_CLEAN);
	
	$app->router->add('ego_anax', function() use ($app) {
			$app->theme->setTitle("Huvudsidan");
			$content=$app->fileContent->get("ego_anax.md");
			$content=$app->textFilter->doFilter($content, "shortcode, markdown");
			$byline=$app->fileContent->get("byline.md");
			$byline=$app->textFilter->doFilter($byline, "shortcode, markdown");
			$app->views->add("ego/page_md",
					array(
						'content'=>$content,
						'byline'=>$byline
						)
					);
			});	
	
	$app->router->add('me', function() use ($app) {
			$app->theme->setTitle("Om mig");
			$content=$app->fileContent->get("me.md");
			$content=$app->textFilter->doFilter($content, "shortcode, markdown");
			$byline=$app->fileContent->get("byline.md");
			$byline=$app->textFilter->doFilter($byline, "shortcode, markdown");
			$app->views->add("ego/page_md",
					array(
						'content'=>$content,
						'byline'=>$byline
						)
					);
			});

	$app->router->add('kmoms', function() use ($app) {
			$app->theme->setTitle("Redovisningar");
			$content=$app->fileContent->get("kmoms.md");
			$content=$app->textFilter->doFilter($content, "shortcode, markdown");
			$byline=$app->fileContent->get("byline.md");
			$byline=$app->textFilter->doFilter($byline, "shortcode, markdown");
			$app->views->add("ego/page_md",
					array(
						'content'=>$content,
						'byline'=>$byline
						)
					);
			}); 	
	$app->router->add('kmom01', function() use ($app) {
			$app->theme->setTitle("Kmom01: PHP-baserade och MVC-inspirerade ramverk");
			$content=$app->fileContent->get("kmom01.md");
			$content=$app->textFilter->doFilter($content, "shortcode, markdown");
			$byline=$app->fileContent->get("byline.md");
			$byline=$app->textFilter->doFilter($byline, "shortcode, markdown");
			$app->views->add("ego/page_md",
					array(
						'content'=>$content,
						'byline'=>$byline
						)
					);
			}); 	
	$app->router->add('kmom02', function() use ($app) {
			$app->theme->setTitle("Kmom01: PHP-baserade och MVC-inspirerade ramverk");
			$content=$app->fileContent->get("kmom02.md");
			$content=$app->textFilter->doFilter($content, "shortcode, markdown");
			$byline=$app->fileContent->get("byline.md");
			$byline=$app->textFilter->doFilter($byline, "shortcode, markdown");
			$app->views->add("ego/page_md",
					array(
						'content'=>$content,
						'byline'=>$byline
						)
					);
			}); 	
	$app->router->add('kmom03', function() use ($app) {
			$app->theme->setTitle("Kmom03: Bygg ett eget tema");
			$content=$app->fileContent->get("kmom03.md");
			$content=$app->textFilter->doFilter($content, "shortcode, markdown");
			$byline=$app->fileContent->get("byline.md");
			$byline=$app->textFilter->doFilter($byline, "shortcode, markdown");
			$app->views->add("ego/page_md",
					array(
						'content'=>$content,
						'byline'=>$byline
						)
					);
			}); 	
	$app->router->add('kmom04', function() use ($app) {
			$app->theme->setTitle("Kmom04: Databaser, ORM och scaffolding");
			$content=$app->fileContent->get("kmom04.md");
			$content=$app->textFilter->doFilter($content, "shortcode, markdown");
			$byline=$app->fileContent->get("byline.md");
			$byline=$app->textFilter->doFilter($byline, "shortcode, markdown");
			$app->views->add("ego/page_md",
					array(
						'content'=>$content,
						'byline'=>$byline
						)
					);
			}); 	
	$app->router->add('kmom05', function() use ($app) {
			$app->theme->setTitle("Kmom05: Bygg ut ramverket");
			$content=$app->fileContent->get("kmom05.md");
			$content=$app->textFilter->doFilter($content, "shortcode, markdown");
			$byline=$app->fileContent->get("byline.md");
			$byline=$app->textFilter->doFilter($byline, "shortcode, markdown");
			$app->views->add("ego/page_md",
					array(
						'content'=>$content,
						'byline'=>$byline
						)
					);
			}); 	
	$app->router->add('kmom06', function() use ($app) {
			$app->theme->setTitle("Kmom06: Verktyg och Continuous integration");
			$content=$app->fileContent->get("kmom06.md");
			$content=$app->textFilter->doFilter($content, "shortcode, markdown");
			$byline=$app->fileContent->get("byline.md");
			$byline=$app->textFilter->doFilter($byline, "shortcode, markdown");
			$app->views->add("ego/page_md",
					array(
						'content'=>$content,
						'byline'=>$byline
						)
					);
			}); 	
	$app->router->add('kmom07', function() use ($app) {
			$app->theme->setTitle("Kmom07/10: Projekt/Examination");
			$content=$app->fileContent->get("kmom07.md");
			$content=$app->textFilter->doFilter($content, "shortcode, markdown");
			$byline=$app->fileContent->get("byline.md");
			$byline=$app->textFilter->doFilter($byline, "shortcode, markdown");
			$app->views->add("ego/page_md",
					array(
						'content'=>$content,
						'byline'=>$byline
						)
					);
			}); 	
	
	$app->router->add('source', function() use ($app) {
			$app->theme->addStylesheet("css/ego_source.css");
			$app->theme->setTitle("Källkod");
			$source=new \Mos\Source\CSource(
					array(
						'secure_dir'=>"..",
						'base_dir'=>"..",
						'add_ignore'=>array(".htaccess")
						)
					);
				$app->views->add("ego/page",
					array(
						'title'=>"Kika på källkoden",
						'content'=>$source->View()
						)
					);
			});
	
	$app->router->add('calendar', function() use ($app) {
			$app->theme->addStylesheet("css/ego_calendar.css");
			$app->theme->setTitle("Kalender");
			$content=$app->fileContent->get("calendar.php");
			$calendar=new \EGO\Calendar\CCalendar();
			$app->views->add("ego/page",
					array(
						'title'=>"Kalender",
						'content'=>$content."<div style='float:left;'>".$calendar->Show()."</div>"
						)
					);
			});

	$app->router->add('ctrlTest', function() use ($app) {
			$app->theme->setTitle("Test av kontroller");
			$content=$app->fileContent->get("ctrlTest.php");
			$app->views->add("ego/page",
					array(
						'title'=>"Test av kontroller",
						'content'=>$content
						)
					);
			});
	
	$app->router->handle();
	$app->theme->render();
?>