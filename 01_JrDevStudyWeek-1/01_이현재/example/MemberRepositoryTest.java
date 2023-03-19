package spring.practice.repository;

import org.junit.jupiter.api.DisplayName;
import org.junit.jupiter.api.Test;
import org.springframework.beans.factory.annotation.Autowired;
import org.springframework.boot.test.autoconfigure.orm.jpa.DataJpaTest;
import spring.practice.domain.Member;

import java.util.Optional;

import static org.assertj.core.api.Assertions.assertThat;

@DataJpaTest
class MemberRepositoryTest {


    @Autowired
    private MemberRepository repository;

    /**
     * JPA 의 nativeQuery 사용 시 발생한 이슈
     * <pre>
     *     이슈 상황
     *     1. Spring Data JPA 를 이용하여 {@link MemberRepository#save(Object)} 메서드를 통해 저장
     *     2. nativeQuery 를 이용한 {@link MemberRepository#update(Long, String)}
     *     3. update 한 정보로 {@link MemberRepository#findById(Object)} 메서드 실행
     *
     *     => 결과 : {@link MemberRepository#findById(Object)} 로 조회한 정보가 업데이트한 정보와 다르다.
     *     <a href= "https://github.com/HyunJaae/example/blob/main/concept/JPA.md">개념 참고</a>
     * </pre>
     */
    @Test
    @DisplayName("이슈 상황 테스트")
    void issue() {
        // given
        Member member = new Member("현재");
        // 영속성 컨텍스트에 저장(= 1차 캐시에 저장)
        repository.save(member);
        // when
        // native query 로 update -> DB 에서 바로 쿼리 실행
        repository.update(member.getId(), "인혁");
        // 1차 캐시에서 먼저 찾는다.
        Optional<Member> findMember = repository.findById(member.getId());
        // then
        // 변경하기 전 이름과 동일하다. 수정 쿼리가 반영되지 않았다.
        assertThat(findMember.get().getName()).isEqualTo("현재");
    }

    /**
     * 1차 캐시 초기화 옵션 추가
     * <pre>
     *     원인
     *     1. 네이티브 쿼리에서 데이터 변경 쿼리를 작성할 때 사용하는 @Modifying 어노테이션은
     *     JPA 엔티티 라이프사이클을 무시하고 쿼리를 실행한다.
     *     2. 때문에 업데이트 시 DB 에는 데이터가 변경되었지만 영속성 컨텍스트에는
     *     데이터가 변경되지 않는다.
     *     3. JPA 의 findById(Long id) 메서드 실행 시 1차 캐시에서 먼저 찾고 있는 경우
     *     DB 에 가지 않고 1차 캐시 값을 그대로 반환한다.
     *
     *     해결
     *     Modifying 어노테이션 옵션 중 clearAutomatically 속성을 true 로 변경한다.
     *     clearAutomatically 속성은 쿼리 실행 이후
     *     1차 캐시 초기화 유무 옵션으로 default 는 false 이다.
     * </pre>
     */
    @Test
    @DisplayName("해결 방법")
    void solve() {
        // given
        Member member = new Member("현재");
        // 영속성 컨텍스트에 저장(= 1차 캐시에 저장)
        repository.save(member);
        // when
        // native query 로 update -> DB 에서 바로 쿼리 실행
        // clearAutomatically 옵션으로 1차 캐시 삭제
        repository.updateName(member.getId(), "인혁");
        // 1차 캐시에서 먼저 찾는다. 1차 캐시가 삭제됐기 때문에 같은 정보가 없어 DB 에서 찾는다.
        Optional<Member> findMember = repository.findById(member.getId());
        // then
        // 변경 후 이름과 동일하다.
        assertThat(findMember.get().getName()).isEqualTo("인혁");
    }

}
