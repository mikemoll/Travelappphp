function montaCheckBox(p){
	condicao = false;
	if (p.colModel[idx]['condicao'] != ''){
		eval('condicao = ("'+p.colModel[idx]['condicao']+'" '+p.colModel[idx]['operador']+' "'+row.cell[p.colModel[idx]['coluna']]+'")?true: false')
	}	
	
	if(condicao){
		return '';
	}else{
		return '<input col="'+p.colModel[idx]['name']+'" type="checkbox" id="'+ row.id +'" name="gridChk_'+ i +'" value="'+ row.id +'" />';
	}
}