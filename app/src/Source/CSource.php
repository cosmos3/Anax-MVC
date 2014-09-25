<?php
/**
 * Class for display sourcecode.
 *
 * @author Mikael Roos, me@mikaelroos.se
 * @copyright Mikael Roos 2010 - 2014
 * @link https://github.com/mosbth/csource
 */

namespace Mos\Source;
	
	class CSource {

		/**
		 * Properties
		 */
		private $options = array();
		
	
		/**
		 * Constructor
		 *
		 * @param array $options to alter the default behaviour.
		 */
		public function __construct($options=array()) {
			$default = array(
				'image_extensions' => array('png', 'jpg', 'jpeg', 'gif', 'ico'),
				'spaces_to_replace_tab' => '  ',
				'ignore' => array('.', '..', '.git', '.svn', '.netrc', '.ssh'),
				'add_ignore' => null, // add array with additional filenames to ignore
				'secure_dir' => '.',  // Only display files below this directory
				'base_dir'   => '.',  // Which directory to start look in, defaults to current working directory of the actual script.
				'query_dir'  => isset($_GET['dir'])  ? strip_tags(trim($_GET['dir']))   : null, // Selected directory as ?dir=xxx
				'query_file' => isset($_GET['file']) ? strip_tags(trim($_GET['file']))  : null, // Selected directory as ?dir=xxx
				'query_path' => isset($_GET['path']) ? strip_tags(trim($_GET['path']))  : null, // Selected directory as ?dir=xxx
				
				'download'=>isset($_GET['download']) ? strip_tags(trim($_GET['download']))  : null

				);

			// Add more files to ignore
			if(isset($options['add_ignore'])) {
				$default['ignore'] = array_merge($default['ignore'], $options['add_ignore']);
			}
			
			$this->options = $options = array_merge($default, $options);
			
			//Backwards compatible with source.php query arguments for ?dir=xxx&file=xxx
			if(!isset($this->options['query_path'])) {
				$this->options['query_path'] = trim($this->options['query_dir'] . '/' . $this->options['query_file'], '/');
			}

			$this->validImageExtensions = $options['image_extensions'];
			$this->spaces         = $options['spaces_to_replace_tab'];
			$this->ignore         = $options['ignore'];
			$this->secureDir      = realpath($options['secure_dir']);
			$this->baseDir        = realpath($options['base_dir']);
			$this->queryPath      = $options['query_path'];
			$this->suggestedPath  = $this->baseDir . '/' . $this->queryPath;
			$this->realPath       = realpath($this->suggestedPath);
			$this->pathinfo       = pathinfo($this->realPath);
			$this->path           = null;
			
			$this->download=$options['download'];

			if(is_dir($this->realPath)) {
				$this->file = null;
				$this->extension = null;
				$this->dir  = $this->realPath;
				$this->path = trim($this->queryPath, '/');
			}
			else if(is_link($this->suggestedPath)) {
				$this->pathinfo = pathinfo($this->suggestedPath);
				$this->file = $this->pathinfo['basename'];
				$this->extension = strtolower($this->pathinfo['extension']);
				$this->dir  = $this->pathinfo['dirname'];
				$this->path = trim(dirname($this->queryPath), '/');
			}
			else if(is_readable($this->realPath)) {
				$this->file = basename($this->realPath);
				$this->extension = strtolower($this->pathinfo['extension']);
				$this->dir  = dirname($this->realPath);
				$this->path = trim(dirname($this->queryPath), '/');
			}
			else {
				$this->file = null;
				$this->extension = null;
				$this->dir  = null;
			}

			if($this->path == '.') {
				$this->path = null;
			}

			$this->breadcrumb = empty($this->path) ? array() : explode('/', $this->path);

			//echo "<pre>" . print_r($this, 1) . "</pre>";

			// Check that dir lies below securedir
			$this->message = null;
			$msg = "<p><i>WARNING: The path you have selected is not a valid path or restricted due to security constraints.</i></p>";
			if(substr_compare($this->secureDir, $this->dir, 0, strlen($this->secureDir))) {
				$this->file = null;
				$this->extension = null;
				$this->dir  = null;
				$this->message = $msg;
			}

			// Check that all parts of the path is valid items
			foreach($this->breadcrumb as $val) {
				if(in_array($val, $this->ignore)) {
					$this->file = null;
					$this->extension = null;
					$this->dir  = null;
					$this->message = $msg;
					break;
				}
			}

		}



		/**
		 * List the sourcecode.
		 */
		public function View() {
			//return $this->GetBreadcrumbFromPath() 
//				. $this->message . $this->ReadCurrentDir(0) . $this->GetFileContent();

			if ($this->download!=null) {
				downloadFile($this->download);
			}
			print_r($this->download);
				
			return $this->GetFileContent();
		}


		/**
		 * Create a breadcrumb of the current dir and path.
		 */
		public function GetBreadcrumbFromPath() {

			$html  = "<ul class='src-breadcrumb'>\n";
			$html .= "<li><a href='?'>" . basename($this->baseDir) . "</a>/</li>";
			$path = null; 
			foreach($this->breadcrumb as $val) {
				$path .= "$val/";      
				$html .= "<li><a href='?path={$path}'>{$val}</a>/</li>";
			}
			$html .= "</ul>\n";

			return $html;
		}
		
		/**
		 * Read all files of the current directory.
		 */
		public function ReadCurrentDir() {
			if (!$this->dir) {
				return;
			}
			$path=basename($this->baseDir); 
			foreach ($this->breadcrumb as $val) {
				$path.=" / ".$val;
			}
			$html="
				Katalog: ".$path."<br/><br/>";
			$html.= "
				<ul class='src-filelist'>";
			foreach(glob($this->dir . '/{*,.?*}', GLOB_MARK | GLOB_BRACE) as $val) {
				if (in_array(basename($val), $this->ignore)) {
					continue;
				}
				$file=basename($val).(is_dir($val) ? "/" : null);
				$path=(empty($this->path) ? null : $this->path."/").$file;
				$html.="
					<li><a href='?path={$path}'>{$file}</a></li>";
			}
			$html.="
				</ul>";
			return $html;
		}
		
		// new 2014-09-10 combobox/<select> =============================
		public function getPathFile() {
			if (!$this->dir) {
				return;
			}
			$cmbPathFile="
				<form class='src-path-file' name='path' action='".$_SERVER['PHP_SELF']."' method='GET'>
					Välj katalog eller fil: 
					<select name='path' onchange='document.forms[0].submit();'>";
			$pathBack="
				<div style='float:left;margin-left:20px;margin-top:2px;'>Katalog-väg:</div>
				<ul class='src-path-back'>
					<li><a href='?'>".basename($this->baseDir)."</a>/</li>";
			$cmbPathFile.="
						<option value=''>".basename($this->baseDir)."</option>";
			$path=null; 
			foreach ($this->breadcrumb as $val) {
				$path.="$val/";
				$pathBack.="
					<li><a href='?path=".$path."'>".$val."</a>/</li>";
				$cmbPathFile.="
						<option value='".$path."'".($path==($this->path)."/" && $this->file=="" ? " selected" :"").">".$path."</option>";
			}
			$pathBack.="
				</ul>";
			foreach (glob($this->dir."/{*,.?*}", GLOB_MARK | GLOB_BRACE) as $val) {
				if (in_array(basename($val), $this->ignore)) {
					continue;
				}
				$file=basename($val).(is_dir($val) ? "/" : null);
				$path=(empty($this->path) ? null : $this->path."/").$file;
				$cmbPathFile.="
						<option value='".$path."'".($file==$this->file ? " selected" :"").">".$file."</option>";
			}
			$cmbPathFile.="
					</select>
				</form>";
			return $cmbPathFile.$pathBack;
		}
		// ===================================================================

		/**
		 * Get the details such as encoding and line endings from the file.
		 */
		public function DetectFileDetails() {

			$this->encoding = null;

			// Detect character encoding
			if(function_exists('mb_detect_encoding')) {
				if($res = mb_detect_encoding($this->content, "auto, ISO-8859-1", true)) {
					$this->encoding = $res;
				}   
			}

			// Is it BOM?
			if(substr($this->content, 0, 3) == chr(0xEF) . chr(0xBB) . chr(0xBF)) {
				$this->encoding .= " BOM";
			}
			
			// Checking style of line-endings
			$this->lineendings = null;
			if(isset($this->encoding)) {
				$lines = explode("\n", $this->content);
				$l = strlen($lines[0]);
				
				if(substr($lines[0], $l-1, 1) == "\r") {
					$this->lineendings = " Windows (CRLF) ";
				} 
				/*elseif(substr($lines[0], $l-1, 1) == "\r") {
				  $this->lineendings = " Mac (xxxx) ";
				} */
				else {
					$this->lineendings = " Unix (LF) ";    
				}
			}
			
		}


		
		/**
		 * Remove passwords from known files from all files starting with config*.
		 */
		public function FilterPasswords() {

			$pattern = array(
				'/(\'|")(DB_PASSWORD|DB_USER)(.+)/',
				'/\$(password|passwd|pwd|pw|user|username)(\s*=\s*[\'|"])(.+)/i',
				//'/(\'|")(password|passwd|pwd|pw)(\'|")\s*=>\s*(.+)/i',
				'/(\'|")(password|passwd|pwd|pw|user|username)(\'|")(\s*=>\s*[\'|"])(.+)/i',
				);


			$message = "Intentionally removed by CSource";
			$replace = array(
				'\1\2\1,  "' . $message . '");',
				'$\1\2' . $message . '";',
				'\1\2\3\4' . $message . '",',
				);

			/*
			$file = 'config';
			if (!strncmp($file, $this->file, strlen($file))) {
			  $this->content = preg_replace($pattern, $replace, $this->content);
			}
			*/

			$this->content = preg_replace($pattern, $replace, $this->content);
		}



		/**
		 * Get the content of the file and format it.
		 */
		public function GetFileContent() {
			$cmb=$this->getPathFile();
			if(!isset($this->file)) {
				return $cmb;//."<br/>".$this->ReadCurrentDir();
			}

			$this->content = file_get_contents($this->realPath);
			$this->DetectFileDetails();
			$this->FilterPasswords();

			// Display svg-image or enable link to display svg-image.
			$linkToDisplaySvg = "";
			if($this->extension == 'svg') {
				if(isset($_GET['displaysvg'])) {
					header("Content-type: image/svg+xml");
					echo $this->content;
					exit;   
				} else {
					$linkToDisplaySvg = "<a href='{$_SERVER['REQUEST_URI']}&displaysvg'>Display as SVG</a>";
				}
			}
			
			// Display image if a valid image file
			if(in_array($this->extension, $this->validImageExtensions)) {

				$baseDir = !empty($this->options['base_dir']) 
					? rtrim($this->options['base_dir'], '/') . '/' 
					: null;
				$this->content = "<div style='overflow:auto;'><img src='{$baseDir}{$this->path}/{$this->file}' alt='[image not found]'>".$baseDir.$this->path."/".$this->file."</div>";

			} 
			
			// Display file content and format for a syntax
			else {
				$this->content = str_replace('\t', $this->spaces, $this->content);
				$this->content = highlight_string($this->content, true);
				$i=0;
				$rownums = "";
				$text = "";
				$a = explode('<br />', $this->content);   

				foreach($a as $row) {
					$i++;
					$rownums .= "<code><a id='L{$i}' href='#L{$i}'>{$i}</a></code><br />";
					$text .= $row . '<br />';
				}

				$this->content = <<<EOD
<div class='src-container'>
	<div class='src-header'><code>{$i} lines {$this->encoding} {$this->lineendings} {$linkToDisplaySvg}</code></div>
	<div class='src-rows'>{$rownums}</div>
	<div class='src-code'>{$text}</div>
</div>
EOD;
			} 

			$download=txtDownloadFile("?download=", $this->realPath);
			
			return $cmb."<p style='clear:both;'><br/>Fil: <span class='src-file'>".$this->file."</span><span class='src-download' style='margin-left:40px;'>".$download."</span></p>".$this->content;

		}


	}

?>