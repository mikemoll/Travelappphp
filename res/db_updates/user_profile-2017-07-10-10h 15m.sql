alter table usuario
 drop lastvisitdate,
 drop lastvisitlocation,
 drop lastvisittext,
 drop nexttripdate,
 drop nexttriplocation,
 drop nexttriptext,
 modify column relationship enum('s','m','ir','e','cu','dp','or','ic','sp','d','w')
 comment 'single, married, in a relationship, engaged, in a civil union, in a domestic partnership, in an open relationship, it is complicated, separated, divorced, widowed';