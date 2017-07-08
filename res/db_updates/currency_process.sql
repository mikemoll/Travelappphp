delete from processo where nome in ('PROC_CAD_LaL','PROC_CAD_APPROVE_EDU','CHANGE_REALDATE','PROC_CAD_BOOKED');

insert into processo (id_processo, nome, descricao, controladores) values ( 165, 'PROC_CURRENCY', 'Currencies', 'insert , edit, delete');