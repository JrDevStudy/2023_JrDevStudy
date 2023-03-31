### [ 특징 ]
# :loudspeaker:목차

1. [특징](#exclamation특징)
2. [장점](#thumbsup장점)
3. [단점](#-1단점)
4. [문법적인 특징 정리](#boom문법적인-특징-정리)
5. [기본 문법](#books기본-문법)



## :exclamation:특징

1. 세계에서 4번째로 많이 쓰이는 RDBMS
2. 다양한 프로그래밍 언어, 어플리케이션 지원, 오픈소스 커뮤니티 활성화
@@ -11,7 +21,7 @@
빠른 성장 속도를 보이는 PostgrSQL


### [ 장점 ]
## :thumbsup:장점

간단 정리 : 오픈 소스 프로젝트로서 라이센스 비용 무료, 인덱스 특화(Partial Index, Parallel Index Scan), 
트랜잭션 ACID 성질 모두 지원
@@ -28,9 +38,9 @@
   4) Graph (ex: Apache AGE)

3. 프로그래밍 언어 지원
   - Server-side language, c/c++, PL/pgSql, PL/Tcl, PL/Perl, PL/Python, PL,Ruby
   - Server-side language, c/c++, PL/pgSql, PL/Tcl, PL/Perl, **PL/Python**, PL,Ruby
   - External Language
   - PL/Java, PL/Lua, PL/R, PL/sh, PL/v8
   - **PL/Java**, PL/Lua, PL/R, PL/sh, PL/v8

4. 대용량 데이터 처리(아래의 기능 덕분에 가능)
  - Table Partitioning
@@ -44,7 +54,7 @@
  - PostgreSQL 은 일반 RDBMS보다 매우 빠르게 작동함
  - BUT, 사용하지 않는 데이터가 계속 쌓이기 때문에 주기적인 데이터 정리 필요

### [ 단점 ]
## :-1:단점

1. MariaDB, MySQL에 비해 업데이트가 불안정함

@@ -54,8 +64,8 @@



 ####  문법적인 특징 정리 

 ## :boom:문법적인 특징 정리
 
 - DUAL 사용 불가

 - SYSDATE 는 now() 함수 사용
@@ -94,9 +104,10 @@
 - MySQL의 IF 함수 사용 불가



#### ---- 생략 가능 ----


### [ 기본 문법 ]
## :books:기본 문법

### DDL(Data Definition Language)
