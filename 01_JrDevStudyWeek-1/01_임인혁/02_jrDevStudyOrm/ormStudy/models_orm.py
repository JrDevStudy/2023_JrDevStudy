from datetime import datetime

from django.db import models

class Member(models.Model):

    member_name = models.CharField(db_index=True, max_length=100 , null=False)
    member_password = models.CharField(max_length=100 , null=False)

    def __init__(self, member_name :str, member_password :str , *args, **kwargs):
        super().__init__(*args, **kwargs)
        # 1.할당 일자
        self.member_name = member_name
        self.member_password = member_password

    class Meta:
        db_table = 'member_name'
        app_label = 'member'

    def __iter__(self):
        yield 'id', self.pk

class MemberInfo(models.Model):
    member_department = models.CharField(db_index=True, max_length=100 , null=False)
    member_job_grade = models.DateTimeField(db_index=True, max_length=100 , null=False)
    member_id = models.ForeignKey(Member, on_delete=models.CASCADE, db_column='member_id', related_name='member_info')

    class Meta:
        db_table = 'member_info'
        app_label = 'member'

    def __iter__(self):
        yield 'id', self.pk