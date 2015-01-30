<?php

Class Reservations_model extends CI_Model
{
	function __construct()
	{
		parent::__construct();
	}
        
        

            public function get_reservations(){

                     $this->db->order_by('delrecord', 'ASC');
                $this->db->order_by("ordernr", "acs");
		$result	= $this->db->get('reservering');
                
		//apply group discount
		$return = $result->result();
                return $return;
        } 
            public function get_dispatch_new_deliveries(){

                     $this->db->order_by('delrecord', 'ASC');
                $this->db->order_by("ordernr", "acs");
		$result	= $this->db->get('reservering');
                
		//apply group discount
		$return = $result->result();
                return $return;
                
                $query ="SELECT opdracht.nr AS nr, ordernr, soort, relaties.nr AS relatienr, relaties.CODE AS relatiecode, relaties.naam1, relaties.naam2, relaties.naam3, 
                leverstop, opdracht.betaalwijze, ideal_status, statuschangedate, opdracht.verzenddatum, webshop, eigennaam, definitief,	
                opdrachtsoort, vaste_leverdatum, neuversend_dt, neuversend, backorder, '0' AS verzendnr
                FROM opdracht, relaties
                WHERE neuversend = true AND definitief = true
                AND opdracht.delrecord = false
                AND (opdracht.soort='opdracht' OR opdracht.soort='gutschrift') 
                AND relaties.nr=opdracht.relatiesnr
                AND relaties.leverstop = false
                ORDER BY statuschangedate ";

        } 
     public function get_dispatch_direct_deliveries(){

                $this->db->order_by('delrecord', 'ASC');
                $this->db->order_by("ordernr", "acs");
		$result	= $this->db->get('reservering');

		//apply group discount
		$return = $result->result();
                return $return;
                
                //all direct deliveries from orders, as smbdy to explain

        } 
        
     public function get_dispatch_complete_deliveries(){

                $this->db->order_by('delrecord', 'ASC');
                $this->db->order_by("ordernr", "acs");
		$result	= $this->db->get('reservering');

		//apply group discount
		$return = $result->result();
                return $return;
                
                //in orders is a column oprachtsort.select type of deluivery = direct, ask difference between direct delivery and other kind

        } 
    public function get_dispatch_fixed_deliveries(){

                $this->db->order_by('delrecord', 'ASC');
                $this->db->order_by("ordernr", "acs");
		$result	= $this->db->get('reservering');

		//apply group discount
		$return = $result->result();
                return $return;
                
                //in orders is a column oprachtsort.select type of deluivery = fixed, ask difference between fixed delivery and other kind

        } 
        
        public function get_shipingstatus(){
            
            
            $query ="SELECT verzending.opdrachtnr, verzending.ordernr, verzending.relatiesnr AS relatienr, relaties.CODE AS relatiecode, relaties.naam1, 
            relaties.naam2, relaties.naam3, verzending.verzenddatum, verzending.verzendnr, opdracht.opdrachtsoort, opdracht.webshop, opdracht.eigennaam, 
            opdracht.vaste_leverdatum, verzending.kommissioniert, verzending.kontrolliert, verzending.magazijnnr, verzending.verzenddoor, 
            '' AS magazijnnaam, '' AS pakketdienst, verzending.geprint
            FROM verzending, relaties, opdracht
            WHERE ! verzending.isverzonden
            AND ! verzending.delrecord
            AND verzending.relatiesnr = relaties.nr
            AND verzending.opdrachtnr = opdracht.nr
            ORDER BY verzending.verzenddatum, verzending.ordernr"; 
            
            
        }
    public function get_backorder_list(){
            
            $query="SELECT opdracht.nr, opdracht.ordernr, opdracht.relatiesnr, opdracht.verzenddatum, opdracht.opdrachtsoort, opdracht.webshop, opdracht.eigennaam, 
            relaties.code as relatiecode, relaties.naam1, relaties.naam2, relaties.management, 
            '0' AS verzendnr 
            FROM opdracht, relaties 
            WHERE opdracht.definitief AND opdracht.backorder AND !allesverzonden AND opdracht.soort='opdracht' AND !opdracht.delrecord AND opdracht.relatiesnr = relaties.nr"; 
            
            
        }
        
        
}        