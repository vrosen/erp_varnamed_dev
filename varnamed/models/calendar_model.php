<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Calendar_model extends CI_Model{


	function getEvents($time){
		
		$today = date("Y/n/j", time());
		$current_month = date("n", $time);
		$current_year = date("Y", $time);
		$current_month_text = date("F Y", $time);
		$total_days_of_current_month = date("t", $time);
		
		$events = array();
		
		$query = $this->db->query("
		SELECT DATE_FORMAT(eventDate,'%d') AS day,
		eventContent,eventTitle,id,user,user_id 
		FROM eventcal 
		WHERE eventDate BETWEEN  '$current_year/$current_month/01' 
						AND '$current_year/$current_month/$total_days_of_current_month'");
        foreach ($query->result() as $row_event)
		{					
			$events[intval($row_event->day)][] = $row_event;
		}
		$query->free_result();  
		return $events;						
	}
	
        function getMyEvents($time, $user_id=0){

                        $today = date("Y/n/j", time());
                        $current_month = date("n", $time);
                        $current_year = date("Y", $time);
                        $current_month_text = date("F Y", $time);
                        $total_days_of_current_month = date("t", $time);
						$c_shop = $this->session->userdata('shop');
                        $events = array();

                        $query = $this->db->query("
                        SELECT DATE_FORMAT(eventDate,'%d') AS day,
                        eventContent,
                        eventTitle,id,user,user_id 
                        FROM eventcal 
                        WHERE  eventDate BETWEEN  '$current_year/$current_month/01' 
                                                        AND '$current_year/$current_month/$total_days_of_current_month' 
                        AND user_id = '$user_id' AND shop_id = '$c_shop'  ");
                        foreach ($query->result() as $row_event)
                        {					
                                $events[intval($row_event->day)][] = $row_event;
                        }
                        $query->free_result();  
                        return $events;						
                }

	function getEventsById($id){
	
	$this->db->where('id', $id);
	$query = $this->db->get('eventcal');
	foreach ($query->result_array() as $event)
		{					
			$data[] = $event;
		}
	$query->free_result();  
	 return $data;						
	}
	
	
	function addEvents($data){
            
            $this->db->insert('eventcal', $data);
            return $this->db->insert_id();

	}
	
	function updateEvent($update_data,$id,$shop_id){
		

			$data = array(
				  'eventDate' 		=> $update_data['date'],
				  'eventTitle' 		=> $update_data['eventTitle'],
				  'eventContent' 	=> $update_data['eventContent']
			);
			$this->db->where('id', $id);
			$this->db->where('shop_id', $shop_id);
			$this->db->update('eventcal', $data); 
	}
	
	function deleteEvent($id){
		$this->db->delete('eventcal', array('id' => $id)); 
	}
	

}
