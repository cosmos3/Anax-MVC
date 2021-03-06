<?php
	namespace EGO\Calendar;
	
	class CCalendar {
		private $href=null;
		private $year=0;
		private $month=0;
		private $yearNow=0;
		private $monthNow=0;
		private $dayNow=0;
		private $monthNames=array(
			"Januari",
			"Februari",
			"Mars",
			"April",
			"Maj",
			"Juni",
			"Juli",
			"Augusti",
			"September",
			"Oktober",
			"November",
			"December"
			);
		private $firstDay=0;
		private $lastDay=0;
		private $prevMonthLastDay=0;
		private $prevMonth=0;
		private $nextMonth=0;
		
		public function __construct() {
			$this->href=htmlentities($_SERVER['PHP_SELF']);
			$this->yearNow=date("Y");
			$this->monthNow=date("n");
			$this->dayNow=date("d");
		}
		
		private function calculateDate() {
			$this->year=readGET('year', $this->yearNow);
			$this->month=readGET('month', $this->monthNow);
			if ($this->month<1) {
				$this->month=12;
				$this->year=$this->year-1;
			} elseif ($this->month>12) {
				$this->month=1;
				$this->year=$this->year+1;
			}
			$this->prevMonth=$this->month-1;
			if ($this->prevMonth<1) {
				$this->prevMonth=12;
			}
			$this->nextMonth=$this->month+1;
			if ($this->nextMonth>12) {
				$this->nextMonth=1;
			}
			$timestamp=mktime(0, 0, 0, $this->month , 1, $this->year);
			$this->lastDay=date("t", $timestamp);
			$month=getdate($timestamp);
			$this->firstDay=$month['wday']-1;
			if ($this->firstDay==-1) {
				$this->firstDay=6;
			}
			$timestamp=mktime(0, 0, 0, $this->prevMonth , 1, $this->year);
			$this->prevMonthLastDay=date("t", $timestamp);
		}

		private function setButton($class, $refYear, $refMonth, $title) {
			return "<a href='?year=".$refYear."&amp;month=".$refMonth."' title='".$title."'><span class='".$class."'></span></a>";
		}
		
		private function getRedDay($i, $year, $month, $day) {
			$html="";
			if (($i % 7)==6) {
				$html=" red-day";
			} elseif ($month==1) {
				if ($day==1 || $day==5) {
					$html=" red-day";
				}
			} elseif ($month==5) {
				if ($day==1) {
					$html=" red-day";
				}
			} elseif ($month==6) {
				if ($day==6) {
					$html=" red-day";
				}
			} elseif ($month==12) {
				if ($day==25 || $day==26) {
					$html=" red-day";
				}
			}
			$easterMonth=3;
			$easterDay=easter_days($year);
			if ($easterDay>31) {
				$easterDay-=31;
				$easterMonth++;
			}
			if ($month==$easterMonth && ($day>=$easterDay-2 && $day<=$easterDay+1)) {
				$html=" red-day";
			} elseif ($easterDay==31 && ($month==$easterMonth+1 && $day==1)) {
				$html=" red-day";
			} elseif ($easterDay<4 && $month==$easterMonth-1) {
				if ($day==(($month==2 ? 27 : 29)+$easterDay)) {
					$html=" red-day";
				}
			}
			return $html;
		}
		
		public function Show() {
			$this->calculateDate();
			$html="
<div id='calendar'>
	<div class='head'>".
				$this->setButton("prev-month", $this->year, $this->month-1, "Föregående månad").
				$this->setButton("prev-year", $this->year-1, $this->month, "Föregående år").
				$this->monthNames[$this->month-1]." - ".$this->year.
				$this->setButton("next-month", $this->year, $this->month+1, "Nästa månad").
				$this->setButton("next-year", $this->year+1, $this->month, "Nästa år")."
	</div>
	<div class='image'>
		<img src='".EGO_URL_ROOT."/webroot/img/calendar/calendar_img_".$this->month.".jpg' width='300' height='200' alt='Månadens bild'/>
	</div>
	<div class='snap'>
	</div>
	<div class='days'>
		<table class='t-calendar'>
			<thead>
				<tr>
					<th></th>
					<th>Mån</th>
					<th>Tis</th>
					<th>Ons</th>
					<th>Tor</th>
					<th>Fre</th>
					<th>Lör</th>
					<th class='red-day'>Sön</th>
				</tr>
			</thead>
			<tbody>";
			$iMax=28+($this->firstDay+$this->lastDay>28 ? 7 : 0)+($this->firstDay+$this->lastDay>35 ? 7 : 0);
			$prevMonthDay=$this->prevMonthLastDay-$this->firstDay+1;
			$nextMonthDay=1;
			for ($i=0; $i<$iMax; $i++) {
				$day=$i-$this->firstDay+1;
				if (($i % 7)==0) {
					$html.="
				<tr>";
					$timestamp=mktime(0, 0, 0, $this->month, $day, $this->year);
					$week=date("W", $timestamp);
					$html.="
					<td class='week'>".$week."</td>";
				}
				if ($i<$this->firstDay) {
					$html.="
					<td class='off-month".$this->getRedDay($i, $this->year, $this->prevMonth, $prevMonthDay)."'>".$prevMonthDay."</td>";
					$prevMonthDay++;
				} elseif ($i<$this->lastDay+$this->firstDay) {
					$divDay="day";
					if ($this->year==$this->yearNow && $this->month==$this->monthNow && $day==$this->dayNow) {
						$divDay="selected";
					}
					$tdDay="class='day".$this->getRedDay($i, $this->year, $this->month, $day);
					$html.="
					<td ".$tdDay."'><div class='".$divDay."'>".$day."</div></td>";
				} else {
					$html.="
					<td class='off-month".$this->getRedDay($i, $this->year, $this->nextMonth, $nextMonthDay)."'>".$nextMonthDay."</td>";
					$nextMonthDay++;
				}
				if (($i % 7)==6) {
					$html.="
				</tr>";
				}
			}			
			$html.="
			</tbody>
		</table>
	</div>
</div>";
			return $html;
		}
	}

?>