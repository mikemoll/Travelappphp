<?php
//	echo '{
//			"page": "1",
//			"total": "4",
//			"rows": [
//			
//			{"id":"238","cell":["<img src="flexigrid/css/images/add.png" />","ZM","ZAMBIA","Zambia","ZMB","894"]},
//			{"id":"237","cell":["<img src="flexigrid/css/images/add.png" />","YE","YEMEN","Yemen","YEM","887"]},
//			{"id":"236","cell":["<img src="flexigrid/css/images/add.png" />","EH","WESTERN SAHARA","Western Sahara","ESH","732"]},
//			{"id":"235","cell":["<img src="flexigrid/css/images/add.png" />","WF","WALLIS AND FUTUNA","Wallis and Futuna","WLF","876"]},
//			{"id":"234","cell":["<img src="flexigrid/css/images/add.png" />","VI","VIRGIN ISLANDS, U.S.","Virgin Islands, U.s.","VIR","850"]},
//			{"id":"233","cell":["<img src="flexigrid/css/images/add.png" />","VG","VIRGIN ISLANDS, BRITISH","Virgin Islands, British","VGB","92"]},
//			{"id":"232","cell":["<img src="flexigrid/css/images/add.png" />","VN","VIET NAM","Viet Nam","VNM","704"]},
//			{"id":"231","cell":["<img src="flexigrid/css/images/add.png" />","VE","VENEZUELA","Venezuela","VEN","862"]},
//			{"id":"230","cell":["<img src="flexigrid/css/images/add.png" />","VU","VANUATU","Vanuatu","VUT","548"]}]
//			}';
// 			{"page":"1",
//			"total":"4",
//			"rows":{"id":"1","cell":["111","ZW","ZIMBABWE","ZWE","716"]}}
//
$array = array('page'=>'1', 'total'=>'4', 'rows'=>
				array(
					array('id'=>'1', 'cell'=>array('close.png', 'ZW','ZIMBABWE','Zimbabwe','ZWE','716')),
					array('id'=>'2', 'cell'=>array('close.png', 'ZW','ZIMBABWE','Zimbabwe','ZWE','716')),
					array('id'=>'1', 'cell'=>array('close.png', 'ZW','ZIMBABWE','Zimbabwe','ZWE','716')),
					array('id'=>'1', 'cell'=>array('close.png', 'ZW','ZIMBABWE','Zimbabwe','ZWE','716')),
					array('id'=>'1', 'cell'=>array('close.png', 'ZW','ZIMBABWE','Zimbabwe','ZWE','716'))
				));
//
echo json_encode($array);
//
//{"page":"1","total":"4","rows":{
//	"id":"1","cell":["close.png","ZW","ZIMBABWE","Zimbabwe","ZWE","716"],
//	"id":"1","cell":["cloasdfasdfasdfse.png","ZasdasdfasdfW","asdfasdfasdfZIMBABWE","Zasdfasdfimbabwe","ZasdfasdfWE","71asdfasdfasdf6"]}}}

