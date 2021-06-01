-- ddl tables
create table catalog_users
(
idrow integer auto_increment primary key,
user_name varchar(100),
pass_key varchar(100),
user_type varchar(20),
flg_active integer,
audit_create varchar(19),
audit_user varchar(100)
);

create table catalog_authentication
(
idrow integer auto_increment primary key,
session_id varchar(100),
user_name varchar(100),
start_date varchar(19),
end_date varchar(19),
flg_active integer
);

create table catalog_table_grant
(
idrow integer auto_increment primary key,
table_name varchar(100),
user_owner varchar(100)
);

-- inserts
insert into catalog_users
values 
(null,'user1','pass1','regular',1,sysdate(),user()),
(null,'user2','pass2','regular',1,sysdate(),user()),
(null,'user3','pass3','regular',1,sysdate(),user()),
(null,'user4','pass4','regular',1,sysdate(),user()),
(null,'admin1','admin1','admin',1,sysdate(),user());

-- ddl functions
drop function if exists validaUsuario;
DELIMITER //
create function validaUsuario(userName varchar(100), passKey varchar(100), userType varchar(20)) returns integer
begin
  declare flg_existe integer;
  select count(1) into flg_existe 
    from catalog_users 
   where user_name = userName
     and pass_key = passKey
     and user_type = userType;
  return flg_existe;
end //
DELIMITER ;

drop function if exists validaSesion;
DELIMITER //
create function validaSesion(sessionId varchar(100)) returns integer
begin
  declare flg_existe integer;
  select count(1) into flg_existe 
    from catalog_authentication 
   where session_id = sessionId
     and flg_active = 1;
  return flg_existe;
end //
DELIMITER ;