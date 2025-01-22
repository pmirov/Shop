<?php

$sql= Tools::ConnectSQL();

$table1= "create table Categories
        (
            id int AUTO_INCREMENT PRIMARY key,
            name varchar(60) UNIQUE not null
        );";

$sql->exec($table1);

$table2 = "create table SubCategories
(
	id int AUTO_INCREMENT primary key not null,
    subname varchar(60) UNIQUE not null,
    CategoriID int,
    FOREIGN key (CategoriId) REFERENCES Categories (id) on UPDATE CASCADE
);";

$sql->exec($table2);

$table3 = "create table Items
(
	id int AUTO_INCREMENT primary key not null,
    name varchar(200) not null, 
    CategoriId int,
    price double,
    pricesale int,
    information varchar(300),
    rate double,
    imagepath varchar(256),
    action int,
    FOREIGN key (CategoriId) REFERENCES Categories (id) on UPDATE CASCADE
);";

$sql->exec($table3);

$table4="create table Images
(
	id int AUTO_INCREMENT primary key not null,
    name varchar(200) not null, 
   	itemId int,
    FOREIGN key (itemId) REFERENCES Items (id) on UPDATE CASCADE
);";
$sql->exec($table4);

$table5="create table Roles
(
	id int AUTO_INCREMENT primary key not null,
    name varchar(50) UNIQUE
   
);";

$sql->exec($table5);

$table6="create table Customers
(
	id int AUTO_INCREMENT primary key not null,
    login varchar(30) UNIQUE,
    PASSWORD varchar(128),
    roleId int,
    discount int, 
    total double,
    imagepath varchar(255),
    FOREIGN KEY (roleId) REFERENCES Roles (id) on UPDATE CASCADE
   
);";

$sql->exec($table6);

$roles = "insert into roles(name)
          values('User'), ('Administrator');";

$sql->exec($roles);

?>