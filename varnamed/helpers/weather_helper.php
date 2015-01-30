<?php

			function _date($time){
				 
				

				$today = date("Y/n/j", time());
				$data['today']= $today;
				
				$current_month = date("n", $time);
				$data['current_month'] = $current_month;
				
				$current_year = date("Y", $time);
				$data['current_year'] = $current_year;
				
				$current_month_text = date("F Y", $time);
				$data['current_month_text'] = $current_month_text;
				
				$total_days_of_current_month = date("t", $time);
				$data['total_days_of_current_month']= $total_days_of_current_month;
				
				$first_day_of_month = mktime(0,0,0,$current_month,1,$current_year);
				$data['first_day_of_month'] = $first_day_of_month;
				
				//geting Numeric representation of the day of the week for first day of the month. 0 (for Sunday) through 6 (for Saturday).
				$first_w_of_month = date("w", $first_day_of_month);
				$data['first_w_of_month'] = $first_w_of_month;
				
				//how many rows will be in the calendar to show the dates
				$total_rows = ceil(($total_days_of_current_month + $first_w_of_month)/7);
				$data['total_rows']= $total_rows;
				
				//trick to show empty cell in the first row if the month doesn't start from Sunday
				$day = -$first_w_of_month;
				$data['day']= $day;
				
				$next_month = mktime(0,0,0,$current_month+1,1,$current_year);
				$data['next_month']= $next_month;
				
				$next_month_text = date("F \'y", $next_month);
				$data['next_month_text']= $next_month_text;
				
				$previous_month = mktime(0,0,0,$current_month-1,1,$current_year);
				$data['previous_month']= $previous_month;
				
				$previous_month_text = date("F \'y", $previous_month);
				$data['previous_month_text']= $previous_month_text;
				
				$next_year = mktime(0,0,0,$current_month,1,$current_year+1);
				$data['next_year']= $next_year;
				
				$next_year_text = date("F \'y", $next_year);
				$data['next_year_text']= $next_year_text;
				
				$previous_year = mktime(0,0,0,$current_month,1,$current_year-1);
				$data['previous_year']=$previous_year;
				
				$previous_year_text = date("F \'y", $previous_year);
				$data['previous_year_text']= $previous_year_text;
				
				return $data;
			  
			 }