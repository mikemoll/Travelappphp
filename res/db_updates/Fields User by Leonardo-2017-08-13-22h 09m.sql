
ALTER TABLE `usuario`
  DROP `idexterno`,
  DROP `dificuldade`;

ALTER TABLE `usuario` ADD `nationality` VARCHAR(50) NOT NULL AFTER `fb_id`, ADD `nationality2` VARCHAR(50) NOT NULL AFTER `nationality`, ADD `passport` VARCHAR(50) NOT NULL AFTER `nationality2`, ADD `passport2` VARCHAR(50) NOT NULL AFTER `passport`, ADD `allergies` VARCHAR(100) NOT NULL AFTER `passport2`, ADD `medicalissues` VARCHAR(200) NOT NULL AFTER `allergies`, ADD `contactname` VARCHAR(100) NOT NULL AFTER `medicalissues`, ADD `contactrelationship` VARCHAR(50) NOT NULL AFTER `contactname`, ADD `contactnumber` VARCHAR(20) NOT NULL AFTER `contactrelationship`, ADD `contactemail` VARCHAR(100) NOT NULL AFTER `contactnumber`, ADD `doctorname` VARCHAR(100) NOT NULL AFTER `contactemail`, ADD `doctornumber` VARCHAR(20) NOT NULL AFTER `doctorname`, ADD `doctoremail` VARCHAR(100) NOT NULL AFTER `doctornumber`;