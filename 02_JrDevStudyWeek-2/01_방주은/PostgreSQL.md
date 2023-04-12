
# :loudspeaker:목차

1. [특징](#exclamation특징)
2. [장점](#thumbsup장점)
3. [단점](#-1단점)
4. [문법적인 특징 정리](#boom문법적인-특징-정리)
5. [기본 문법](#books기본-문법)



## :exclamation:특징

1. 세계에서 4번째로 많이 쓰이는 RDBMS
2. 다양한 프로그래밍 언어, 어플리케이션 지원, 오픈소스 커뮤니티 활성화
3. 오픈소스 소프트웨어


![](https://velog.velcdn.com/images/qwd101/post/2ba678c0-1f29-4613-a872-16a163b1d22d/image.png)


빠른 성장 속도를 보이는 PostgrSQL


## :thumbsup:장점

간단 정리 : 오픈 소스 프로젝트로서 라이센스 비용 무료, 인덱스 특화(Partial Index, Parallel Index Scan), 최대 인덱스 개수 무제한, 트랜잭션 ACID 성질 모두 지원

1. 최다 SQL 기능/표준 지원
- SQL 데이터 베이스 쿼리 언어에 대한 179 항목의 SQL 표준 중에 약 95%인 170 항목 지원
![](https://velog.velcdn.com/images/qwd101/post/dc7ac975-7569-43f9-b263-42b4e590e60e/image.png)

2. 풍부한 데이터 유형 지원
   1) Key-Value, XML
   2) JSON, JSONB
   3) Clumnar Store
   4) Graph (ex: Apache AGE)
   
3. 프로그래밍 언어 지원
   - Server-side language, c/c++, PL/pgSql, PL/Tcl, PL/Perl, PL/Python, PL,Ruby
   - External Language
   - PL/Java, PL/Lua, PL/R, PL/sh, PL/v8

4. 대용량 데이터 처리(아래의 기능 덕분에 가능)
  - Table Partitioning
  - Paraller query & multiple processes
  - Analytic & Aggregate functions
  - Indexing & Join
  
5. 다중버전 동시성 제어(MVCC)
  - 동시성 제어란 : 다수의 사용자가 동시에 DBMS 트랜잭션을 일으켜 상호 간섭이 발생할 때 DB를 보호하는 통제 방법
  - MVCC 란 : 데이터에 접근하는 사용자는 갱신/변경된 데이터를 다른 그 이전 데이터와 버전을 달리 해 관리하고, 이를 기반으로 일관성을 유지하는 동시성 제어의 한 방법. 
  - PostgreSQL 은 일반 RDBMS보다 매우 빠르게 작동함
  - BUT, 사용하지 않는 데이터가 계속 쌓이기 때문에 주기적인 데이터 정리 필요
  
## :-1:단점

1. MariaDB, MySQL에 비해 업데이트가 불안정함

2. 메모리 성능이 떨어짐
  - 모든 새로운 클라이언트 연결에 대해 새로운 프로세스를 일으키기 때문에 각 프로세스에 메모리(약10MB)가 할당되므로 많은 연결이 있는 경우 메모리가 빠르게 증가함. 
  - 따라서 읽기가 많은 간단한 작업의 경우 일반적으로 다른 RDBMS보다 성능이 떨어짐.


 ## :boom:문법적인 특징 정리
 - DUAL 사용 불가
 
 - SYSDATE 는 now() 함수 사용
 
 - NVL 은 COALESCE 함수 사용
 
 (ex) SELECT COALESCE(user_id, 0) FROM user_t; user_id가 NULL이면 0으로 출력)
 - 시퀀스는 NEXTVAL('시퀀스명') 사용
 
 - ROWNUM 은 ROW_NUMBER() OVER() 함수 사용
 
 - DECODE 사용 불가 -> CASE 문으로 대체
 
 - 데이터 형 변환은 "값::[변환할 데이터 타입]" ex) SELECT '1'::int
 
 - INNER,OUTER,EQUI,LEFT,RIGHT,FULL OUTER,CROSS  + JOIN 모두 가능
 (INNER는 잘 안된다고 하는 글이 있음)

 - MySQL은 Database > Table 이지만
 PostgreSQL은 Database > Schema > Table 구조
 
 - 모든 데이터베이스 확인 : \dn (show databases;)
 
 - 모든 테이블 확인 : \dt (show tables;)
 
 - 자동 증가 값 : SERIAL (AUTO_INCREMENT)
 
 - 대소문자 / 따옴표 구분 철저함 > 명확히 구분해야 함!!!!
 
 - 작은 따옴표는 string을 표현하고 큰 따옴표는 컬럼명과 테이블명 같은 identifier 네이밍에 활용
 
 - 기본적으로 모든 identifier를 lower-case(소문자)로 인식하므로 테이블명이나 컬럼명에 대문자가 있다면  큰 따옴표를 사용해야 함
 
 - 오른쪽 공백이 들어간 문자를 다르게 인식 (ex: 'a' =\= 'a  ')

 - MySQL의 IF 함수 사용 불가
 
 



#### ---- 생략 가능 ----

## :books:기본 문법

### DDL(Data Definition Language)

#### Database

CREATE DATABASE 데이터베이스_이름 [OWNER 소유자명];

ALTER DATABASE 데이터베이스_이름 OWNER TO 소유자명;

ALTER DATABASE 데이터베이스_이름 RENAME TO 데이터베이스_이름2;

ALTER DATABASE 데이터베이스_이름 SET [바꿀_설정값] TO [값];

DROP DATABASE 데이터베이스_이름;

 


#### Schema

CREATE SCHEMA 스키마명 [AUTHORIZATION 소유자명];

ALTER SCHEMA 스키마명 RENAME TO 이름;

ALTER SCHEMA 스키마명 OWNER TO 소유자;

DROP SCHEMA 스키마명;

 

 

#### Tablespace

CREATE TABLESPACE 테이블스페이스명 [OWNER 소유자명] [LOCATION 위치];

ALTER TABLESPACE 테이블스페이스명 RENAME TO 테이블스페이스명;

ALTER TABLESPACE 테이블스페이스명 OWNER TO 소유자명;

DROP TABLESPACE 테이블스페이스명;

 

 

#### Table

CREATE TABLE 테이블명(

컬럼이름 데이터타입 [NOT NULL | NULL] [DEFAULT default_value] [UNIQUE [KEY]] [[PRIMARY] KEY] [타테이블명 (컬럼명) ] ,

[CONSTRAINT] PRIMARY KEY 칼럼이름) ,

[CONSTRAINT] UNIQUE [INDEX | KEY] [인덱스이름] (칼럼이름) ,

[CONSTRAINT] FOREIGN KEY [인덱스이름] (칼럼이름) (타테이블명 (컬럼명) ) ,

CHECK (expr)

)


ALTER TABLE 테이블명 ADD CHECK (제약조건);

ALTER TABLE 테이블명 ADD CONSTRAINT 제약조건명 UNIQUE (컬럼명);

ALTER TABLE 테이블명 ADD FOREIGN KEY (FK이름) REFERENCES 타테이블명(칼럼명);

ALTER TABLE 테이블명 RENAME TO 새_테이블명;

 

#### COLUMN

ALTER TABLE 테이블_이름 ADD COLUMN 컬럼_이름 TYPE;

ALTER TABLE 테이블_이름 DROP COLUMN 컬럼_이름;

ALTER TABLE 테이블_이름 CHANGE 컬럼_이름1 컬럼_이름2 [TYPE];

ALTER TABLE 테이블_이름 ALTER COLUMN 컬럼_이름 TYPE NOT NULL;

ALTER TABLE 테이블_이름 RENAME COLUMN 컬럼_이름 TO 새_컬럼_이름;

### DML(Data Manipulation Language)

 

SELECT [DISTINCT] 컬럼명..

FROM 테이블명

[ WHERE condition ]

[ GROUP BY expression [, ...] ]

[ HAVING condition [, ...] ]

[ ORDER BY expression [ ASC | DESC | USING operator ] [ NULLS { FIRST | LAST } ]

[ LIMIT { count | ALL } ]

[ OFFSET start [ ROW | ROWS ] ]

 

INSERT INTO 테이블명 (컬럼1, 컬럼2 …) VALUES (값1, 값2 …);

INSERT INTO 테이블명 (컬럼1, 컬럼2 …) SELECT ~ ;

 

UPDATE 테이블명 SET 칼럼명 = 값 [WHERE 조건];

 

DELETE FROM 테이블명 [WHERE 조건];

 

 
### DCL (Data Control Language)


CREATE USER 유저_이룸 [PASSWORD '패스워드'] [권한];

ALTER USER [유저_이름1] RENAME TO [유저_이름2];

ALTER USER 유저_이름 WITH PASSWORD '패스워드';

ALTER USER 유저_이름 WITH [권한];

GRANT [권한] [ ON object [,...] ] TO { PUBLIC | GROUP group | username};

REVOKE [권한] [ON object [,...] ] FROM { PUBLIC | GROUP gname | username };

Begin Transaction;

Commit / rollback ;
