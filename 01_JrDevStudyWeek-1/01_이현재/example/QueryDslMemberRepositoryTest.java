package spring.practice.repository;

import com.querydsl.jpa.impl.JPAQuery;
import com.querydsl.jpa.impl.JPAUpdateClause;
import org.junit.jupiter.api.DisplayName;
import org.junit.jupiter.api.Test;
import org.springframework.beans.factory.annotation.Autowired;
import org.springframework.boot.test.context.SpringBootTest;
import spring.practice.domain.Member;
import spring.practice.domain.QMember;

import javax.persistence.EntityManager;
import javax.persistence.EntityManagerFactory;
import javax.persistence.EntityTransaction;
import javax.transaction.Transactional;

import static org.assertj.core.api.Assertions.assertThat;

@Transactional
@SpringBootTest
class QueryDslMemberRepositoryTest {
    @Autowired
    private EntityManagerFactory emf;

    /**
     * nativeQuery 를 queryDsl 로 변경
     * <pre>
     *     변경 이유
     *     1. 가독성
     *     2. 자동완성
     * </pre>
     */
    @Test
    @DisplayName("Querydsl 변경")
    void queryDsl() {
        // given
        Member member = new Member("현재");

        EntityManager em = emf.createEntityManager();
        EntityTransaction transaction = em.getTransaction();
        transaction.begin();
        em.persist(member);

        QMember qMember = new QMember("m");

        // when
        JPAUpdateClause update = new JPAUpdateClause(em, qMember);

        update.set(qMember.name, "인혁")
                .where(qMember.id.eq(member.getId()))
                .execute();

        em.flush();
        transaction.commit();
        em.clear();

        // then
        JPAQuery<Member> jpaQuery = new JPAQuery<>(em);
        Member findMember = jpaQuery.from(qMember)
                .where(qMember.id.eq(member.getId()))
                .fetchOne();
        assertThat(findMember.getName()).isEqualTo("인혁");
    }
}
