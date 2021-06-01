-- ddl user
CREATE USER dentry IDENTIFIED BY "Or4cle##202105!" DEFAULT TABLESPACE DATA QUOTA 20480M ON DATA;
GRANT CONNECT TO dentry;
GRANT CREATE SESSION TO dentry;

-- ddl tables
create table dentry.catalog_users
(
idrow INTEGER primary key,
user_name varchar(100),
pass_key varchar(100),
user_type varchar(20),
flg_active integer,
audit_create date,
audit_user varchar(100)
);

create table dentry.catalog_authentication
(
idrow INTEGER primary key,
session_id varchar(100),
user_name varchar(100),
start_date date,
end_date date,
flg_active integer
);

create table dentry.catalog_table_grant
(
idrow INTEGER primary key,
table_name varchar(100),
user_owner varchar(100)
);

CREATE SEQUENCE dentry.dentry_seq_gen
 START WITH     1000
 INCREMENT BY   1
 NOCACHE
 NOCYCLE;

-- inserts
insert into dentry.catalog_users
values (dentry.dentry_seq_gen.nextval,'user1','pass1','regular',1,CURRENT_DATE,USER);
insert into dentry.catalog_users
values (dentry.dentry_seq_gen.nextval,'user2','pass2','regular',1,CURRENT_DATE,USER);
insert into dentry.catalog_users
values (dentry.dentry_seq_gen.nextval,'user3','pass3','regular',1,CURRENT_DATE,USER);
insert into dentry.catalog_users
values (dentry.dentry_seq_gen.nextval,'user4','pass4','regular',1,CURRENT_DATE,USER);
insert into dentry.catalog_users
values (dentry.dentry_seq_gen.nextval,'admin1','admin1','admin',1,CURRENT_DATE,USER);
COMMIT;

-- ddl functions
CREATE OR REPLACE FUNCTION dentry.validaUsuario(userName IN VARCHAR, passKey IN VARCHAR, userType IN VARCHAR) 
RETURN NUMBER 
IS flg_existe NUMBER;
BEGIN 
  SELECT COUNT(1)
    INTO flg_existe
    FROM dentry.catalog_users
   WHERE user_name = userName
     AND pass_key = passKey
     AND user_type = userType
     AND flg_active = 1;
  
  RETURN flg_existe;
END;
/

CREATE OR REPLACE FUNCTION dentry.validaSesion(sessionId IN VARCHAR) 
RETURN NUMBER 
IS flg_existe NUMBER;
BEGIN 
  SELECT COUNT(1)
    INTO flg_existe
    FROM dentry.catalog_authentication
   WHERE session_id = sessionId
     AND flg_active = 1;
  
  RETURN flg_existe;
END;
/
