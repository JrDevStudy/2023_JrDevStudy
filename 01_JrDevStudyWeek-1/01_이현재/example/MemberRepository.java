package spring.practice.repository;

import org.springframework.data.jpa.repository.JpaRepository;
import org.springframework.data.jpa.repository.Modifying;
import org.springframework.data.jpa.repository.Query;
import org.springframework.data.repository.query.Param;
import spring.practice.domain.Member;

import javax.transaction.Transactional;

public interface MemberRepository extends JpaRepository<Member, Long> {

    @Transactional
    @Modifying
    @Query(value = "update member m set m.name = :name where m.id = :id", nativeQuery = true)
    void update(@Param("id") Long id, @Param("name") String name);

    @Transactional
    @Modifying(clearAutomatically = true)
    @Query(value = "update member m set m.name = :name where m.id = :id", nativeQuery = true)
    void updateName(@Param("id") Long id, @Param("name") String name);
}
