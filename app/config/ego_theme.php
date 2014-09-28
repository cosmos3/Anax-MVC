<?php
	return array(
		'settings'=>array(
				'path'=>ANAX_INSTALL_PATH."theme/",
				'name'=>"anax-base"
				),
			'views'=>array(
				array(
					'region'=>"header",
					'template'=>"ego/header",
					'data'=>array(
						'siteTitle'=>"",
						'siteTagline'=>"... med ett stort självintresse!"
						),
					'sort'=>-1
					),
				array(
					'region'=>"footer",
					'template'=>"ego/footer",
					'data'=>array(),
					'sort'=>-1
					),
				array(
					'region'=>"navbar",
					'template'=>array(
						'callback'=>function() {
							return $this->di->navbar->create();
						}
						),
					'data'=>array(),
					'sort'=>-1
					),
				),
			'data'=>array(
				'lang'=>"sv",
				'title_append'=>" || EGO - ANAX (en liten webbmall)",
				'stylesheets'=>array(
					"css/ego_common.css",
					"css/ego_navbar.css",
					"css/ego_ctrl.css"
					),
				'style'=>null,
				'favicon'=>"favicon.ico",
				'modernizr'=>"js/modernizr.js",
				'jquery'=>"js/jquery-2.1.1.min.js",
				'javascript_include'=>array(
					"js/ego_common.js"
					),
				'google_analytics'=>"UA-54672703-2"
				)
			);

?>