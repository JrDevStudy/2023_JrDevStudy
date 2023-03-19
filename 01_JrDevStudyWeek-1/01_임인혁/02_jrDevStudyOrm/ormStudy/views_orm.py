import logging
from typing import List

from django.db.models import QuerySet
from django.views import View
from rest_framework import viewsets, mixins
from rest_framework.response import Response

from ormStudy.models_orm import Member, MemberInfo

logger = logging.getLogger()

class ViewOrm(viewsets.GenericViewSet , mixins.ListModelMixin , View):

    # 예제1
    def get_member(self, request):
        # a.QuerySet : 지연 로딩 프록시 객체
        # b.하나의 QuerySet은 반드시 1 개의 Query(메인 쿼리)를 가지며
        # c.0 ~N개의 QuerySet(추가 쿼리셋)을 가진다.

        member_list :QuerySet = Member.objects.all()    # -> QuerySet(select * from member)

        # 1. type(member_list) == QuerySet -> true
        if isinstance(member_list , QuerySet):
            logger.info(type(member_list))

        # 2. 모든 멤버를 member_list 객체에 할당 해당 로직 실행시 -> select * from member query transaction 발생
        # 2-1. 해당 로직이 실행되지 않을시 transaction 발생하지 않는다.
        member_list :list[Member] = list(member_list)

        # type(member_list) == list[Member] -> true
        if isinstance(member_list , list):
            logger.info(type(member_list))

        return Response({'data': member_list})

    # 예제2
    def bad_case(self, request):
        # 시나리오 : 가장 첫번째 멤버의 이름이 임인혁인지 확인 후 True이면 전체 멤버 리턴

        # 1. member_list를 선언하는 시점에서 Sql은 호출되지 않는다
        member_list :QuerySet = Member.objects.all(); # -> QuerySet(select * from member)

        # 2. 가장 첫번째 멤버를 member 객체에 할당 해당 로직 실행시 -> select * from member limit 1 query transaction 발생
        member :Member = member_list[0]

        # 3. 가장 첫번째 멤버의 이름이 "임인혁이면" -> select * from member query transaction 발생
        member_list = member.member_name == "임인혁" if list(member_list) else []

        return Response({'data': member_list})

    # 예제3
    def good_case(self, request):
        # 시나리오 : 가장 첫번째 멤버의 이름이 임인혁인지 확인 후 True이면 전체 멤버 리턴

        # 1. member_list를 선언하는 시점에서 Sql은 호출되지 않는다
        member_list: QuerySet = Member.objects.all();  # -> QuerySet(select * from member)

        # 2. 가장 첫번째 멤버를 member 객체에 할당 해당 로직 실행시 -> select * from member query transaction 발생
        member_list: List[Member] = list(member_list)

        # 3. 가장 첫번째 멤버의 이름이 "임인혁이면" query transaction 발생하지 않고 list에서 조회
        member_list = member_list[0].member_name == "임인혁" if member_list else []

        return Response({'data': member_list})

    # 예제4 N+1 Bad Case
    def n_plus_one_bad(self, request):
        # 사전 정보 : member 테이블의 row는 총 10개이다.

        # 1. member_list를 선언하는 시점에서 Sql은 호출되지 않는다
        member_list: QuerySet = Member.objects.all();  # -> QuerySet(select * from member)

        # 2. 전체  member를 member_list 객체에 할당 해당 로직 실행시 -> select * from member transaction 발생
        member_list: List[Member] = list(member_list)

        # 3. memeber 리스트의 자식 테이블인 member_info 값 확인
        # 3-1. member row가 10개라면 10명분의 user_info를 찾기위한 transaction이 10번 발생한다.
        for member in member_list:
            print(member.member_info)

        """
            4. 심각한 n+1 문제 발생
            4-1. 10명의 멤버를 찾아오는 쿼리 1개 (select * from member)
            4-2. 10명의 멤버의 user_info를 찾아오는 쿼리 10개 (select * from member a , member_info b where a.id = b.member_id)
            4-3. Big-O(n^2)의 시간 복잡도를 가지기 때문에 대용량 데이터 처리시 성능에 굉장히 치명적이다.
        """

        return Response({'data': member_list})

    # 예제5 N+1 Good Case_1
    def n_plus_one_good_case_1(self, request):
        # 1. select_related : join해서 가져온다.
        # 1-2. 정방향 참조모델 : 자식 테이블 [ 부모 테이블의 fk ] -> [ 부모 테이블의 pk ] 부모 테이블
        # 1-3. select a.* from parent a left inner join child b on b.parent_id = a.id

        # 2. member table의 member_id를 fk로 가진 모든 member_info 조회
        # 2-1. 실행쿼리 -> select a.* from member a left inner join member_info b on b.member_id = a.id
        member_info :QuerySet = MemberInfo.objects.all().select_related('member')

        # 2-3. 전체 member_info를 member_list 객체에 할당 해당 로직 실행시 -> select a.* from member a left inner join member_info b on b.member_id = a.id
        member_info_list :List[MemberInfo] = list(member_info)

        # 3. member table의 member_id를 fk로 가진 모든 member_info중 member의 user_name이 임인혁인 member_info 조회
        # 3-1. select a.* from member a left inner join member_info b on b.member_id = a.id where a.username = '임인혁'
        # 3-2. member_info: QuerySet = MemberInfo.objects.all().select_related('member').filter(member__username = '임인혁')

        """
            4. 이전과 반대로 select a.* from member a left inner join member_info b on b.member_id = a.id 쿼리 한번만 발생
            4-1. member table의 member_id를 fk로 가진 모든 member_info 조회
            4-2. Big-O(1)의 시간 복잡도를 가지기 때문에 대용량 데이터 처리시에도 성능에 영향을 주지 않는다.
        """

        return Response({'data': member_info_list})


    def n_plus_one_good_case_2(self, request):
        # 1. 역방향 참조모델 : 부모 테이블 [ 부모 테이블의 pk ] -> [ 자식 테이블의 fk ] 자식 테이블
        # 1-2. ex ) select a.* from child a left inner join parent b on b.id  = a.parent_id

        # 2. prefetch_related() : query를 하나 더 생성한다. / joining
        # 2-1. 실행쿼리1 -> select a.* from member a
        # 2-2. 실행쿼리2 -> select a.* from member_info a where a.member_id in (~~~)
        # 2-3. member table 조회
        # 2-4. member_info table의 member_id column을 in문으로 2-1에서 찾아온 member의 id를 통해서 조회
        # 2-5. result : member , member_info
        member:QuerySet = Member.objects.all().prefetch_related('member_info')


        # 3. member의 전체 member_info를 member_list 객체에 할당
        # 3-1. 실행쿼리1 -> select a.* from member a
        # 3-2. 실행쿼리2 -> select a.* from member_info a where a.member_id in (~~~)
        # 3-3. result : member_info
        member_info_list :List[MemberInfo] = list(member.member_info)

        """
            4-1. 실행쿼리1 -> select a.* from member a
            4-2. 실행쿼리2 -> select a.* from member_info a where a.member_id in (~~~)
            4-3. Big-O(n)의 시간 복잡도를 가지기 때문에 대용량 데이터 처리시에 주의해서 사용한다면 성능에 크게 영향을 주지 않는다.
        """

        return Response({'data': member_info_list})
