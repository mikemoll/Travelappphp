insert into usuario (id_usuario, loginuser, nomecompleto, lastname, senha, datasenha, tipo, email, senhaemail, assinaturaemail, smtp, porta, grupo, ativo, excluivel, editavel, id_empresa, idexterno, dificuldade, trocasenhatempo, paginainicial, telephone, Photo, approved, actualcity, actualcountry, liveincity, liveincountry, birthdate, gender, relationship, bio, instagram, twitter, facebook, occupation, dreamjob, calendartype, traveledto, education, hometowncity, hometowncountry, confirmurl)
values('2', NULL, 'general users', NULL, NULL, NULL, 'grupo', NULL, NULL, NULL, NULL, NULL, NULL, 'S', 'S', 'S', NULL, NULL, 'null', NULL, NULL, NULL, NULL, 'N', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL);

insert into permissao (id_permissao, id_processo, ver, inserir, excluir, editar, id_usuario) values ('2', '1', 'S', 'S', 'S', 'S', '2');